import clip
import os
import torch
import pandas as pd
from PIL import Image
from tqdm import tqdm
import json
import time
import pickle


device = "cuda" if torch.cuda.is_available() else "cpu"
model, preprocess = clip.load('RN50', device)


def make_embeddings(output_dir):
	file = pd.read_csv("../SemArt/semart_train.csv", sep="\t", encoding="latin-1")
	
	image_feature_dump = []
	text_feature_dump = []

	with torch.no_grad():

		for i in tqdm(range(1000)):
			image = preprocess(Image.open(
				os.path.join("../SemArt/Images", file['IMAGE_FILE'][i])
				)).unsqueeze(0).to(device)
			text = clip.tokenize([file['AUTHOR'][i]]).to(device)

			image_features = model.encode_image(image)
			text_features = model.encode_text(text)
			image_features /= image_features.norm(dim=-1, keepdim=True)
			text_features /= text_features.norm(dim=-1, keepdim=True)

			image_feature_dump.append(image_features)
			text_feature_dump.append(text_features)

			del image
			del text
			del image_features
			del text_features

	image_feature_dump = torch.stack(image_feature_dump)
	text_feature_dump = torch.stack(text_feature_dump)

	torch.save(image_feature_dump, os.path.join(output_dir, "image_features.pt"))
	torch.save(text_feature_dump, os.path.join(output_dir, "text_features.pt"))


def run_retrieval(query_folder, feature_dir, k, type):
	file = pd.read_csv(r"C:\xampp\htdocs\SemArt\SemArt\semart_train.csv", sep="\t", encoding="latin-1")

	input_query = preprocess(
		Image.open(r'C:\xampp\htdocs\SemArt\src\queries\1.jpg')
		).unsqueeze(0).to(device)
	
	
	if type == 'image':
		input_features = model.encode_image(input_query)
		input_features /= input_features.norm(dim=-1, keepdim=True)

		image_feature_dump = torch.load(r'C:\xampp\htdocs\SemArt\src\embeddings\image_features.pt').squeeze(1)
		sim = (100*input_features @ image_feature_dump.T).softmax(dim=-1)
		values, indices = sim[0].topk(k)

		return_data = {"images": [], "text": []}
		indices = [int(x) for x in indices]
		
		for idx in indices:
			image_to_return = file['IMAGE_FILE'][idx]
			return_data["images"].append(image_to_return)

			text_to_return = file['AUTHOR'][idx]
			return_data["text"].append(text_to_return)
		
		return return_data

	elif type == 'text':
		f = open(os.path.join(query_folder, "input_text.txt"), "r")
		input_query = f.read()
		f.close()
		
		text = clip.tokenize([input_query]).to(device)
		input_features = model.encode_text(text)
		input_features /= input_features.norm(dim=-1, keepdim=True)

		image_feature_dump = torch.load(os.path.join(feature_dir, "image_features.pt")).squeeze(1)
		sim = (100*input_features @ image_feature_dump.T).softmax(dim=-1)
		values, indices = sim[0].topk(k)

		return_data = {"images": [], "text": []}
		for idx in indices:
			image_to_return = file['IMAGE_FILE'][idx]
			return_data["images"].append(image_to_return)

			text_to_return = file['AUTHOR'][idx]
			return_data["text"].append(text_to_return)
		
		return return_data


def main(query_folder="queries", type="image", result_folder="results"):
	print("waiting...")
	while len(os.listdir(r'C:\xampp\htdocs\SemArt\src\queries')) == 0:
		time.sleep(10)
	print("received query, now retrieveing...")
	return_data = run_retrieval(query_folder, "embeddings", 3, type)

	#print(" ")
	#print(return_data)
	#print(" ")
	with open("sample.json", "w") as outfile:
		json.dump(return_data, outfile)
	print("Found matching images")


main()