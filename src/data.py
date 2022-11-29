# from selenium import webdriver
# from selenium.webdriver.common.keys import Keys
# from selenium.webdriver.common.by import By
import mariadb
import sys
import pandas as pd

# Connect to MariaDB Platform
try:
    conn = mariadb.connect(
        user="jaisidh",
        password="dbms",
        host="localhost",
        port=3306,
        database="dbms_project"

    )
except mariadb.Error as e:
    print(f"Error connecting to MariaDB Platform: {e}")
    sys.exit(1)

# Get Cursor
cur = conn.cursor()

file = pd.read_csv("../SemArt/semart_train.csv", sep="\t", encoding="latin-1")
file = file.dropna()
file = file.iloc[:1000, :]
file.columns = file.columns.str.lower()

for i in range(0, 1):
	# cur.execute(f"""insert into dbms_project.painting values ("{file['image_file'][i]}", "{file['author'][i]}", "{file['description'][i]}")""")
	cur.execute(f"""insert into dbms_project.intricacies values "({file['image_file'][i]}", "{file['technique'][i]}", "{file['school'][i]}")""")
	cur.execute(f"""insert into dbms_project.contemporary values "({file['image_file'][i]}", "{file['type'][i]}", "{file['timeframe'][i]}")""")
conn.commit()



# driver = webdriver.Chrome()
# driver.get("")

# author = driver.find_element_by_xpath("")
# title = driver.find_element_by_xpath("")
# school = driver.find_element_by_xpath("")
# technique = driver.find_element_by_xpath("")
# time_frame = driver.find_element_by_xpath("")
# genre = driver.find_element_by_xpath("")
# image = driver.find_element_by_xpath("")