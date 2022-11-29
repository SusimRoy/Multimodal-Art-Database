import clip
import os
import torch
import pandas as pd
from PIL import Image
from tqdm import tqdm
import time

device = "cuda" if torch.cuda.is_available() else "cpu"
model, preprocess = clip.load('RN50', device)


def make_embeddings(output_dir):
	file = pd.read_csv("../SemArt/semart_train.csv", sep="\t", encoding="latin-1")
	
	image_feature_dump = []
	text_feature_dump = []

	for i in tqdm(range(1000)):
		image = preprocess(Image.open(
			os.path.join("../SemArt/Images", file['image_file'][i])
			)).unsqueeze(0).to(device)
		text = clip.tokenize([file['author'][i]]).to(device)

		image_features = model.encode_image(image)
		text_features = model.encode_text(text)
		image_features /= image_features.norm(dim=-1, keepdim=True)
		text_features /= text_features.norm(dim=-1, keepdim=True)

		image_feature_dump.append(image_features)
		text_feature_dump.append(text_features)
	
	image_feature_dump = torch.stack(image_feature_dump)
	text_feature_dump = torch.stack(text_feature_dump)

	torch.save(image_feature_dump, os.path.join(output_dir, "image_features.pt"))
	torch.save(text_feature_dump, os.path.join(output_dir, "text_features.pt"))


def run_retrieval(input_query, feature_dir, k, type):
	file = pd.read_csv("../SemArt/semart_train.csv", sep="\t", encoding="latin-1")

	if type == 'image':
		input_features = model.encode_image(input_query)
		input_features /= input_features.norm(dim=-1, keepdim=True)

		image_feature_dump = torch.load(os.path.join(feature_dir, "image_features.pt"))
		sim = (100*input_features @ image_feature_dump.T).softmax(dim=-1, keepdim=True)
		values, indices = sim[0].topk(k)

		return_data = {"images": [], "text": []}
		for idx in indices:
			image_to_return = file['image_file'][idx]
			return_data["images"].append(image_to_return)

			text_to_return = file['author'][idx]
			return_data["text"].append(text_to_return)
		
		return return_data

	elif type == 'text':
		text = clip.tokenize([input_query]).to(device)
		input_features = model.encode_text(text)
		input_features /= input_features.norm(dim=-1, keepdim=True)

		image_feature_dump = torch.load(os.path.join(feature_dir, "image_features.pt"))
		sim = (100*input_features @ image_feature_dump.T).softmax(dim=-1, keepdim=True)
		values, indices = sim[0].topk(k)

		return_data = {"images": [], "text": []}
		for idx in indices:
			image_to_return = file['image_file'][idx]
			return_data["images"].append(image_to_return)

			text_to_return = file['author'][idx]
			return_data["text"].append(text_to_return)
		
		return return_data


make_embeddings("embeddings")