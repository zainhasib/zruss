# libraries
import numpy as np 
import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import linear_kernel
from flask import Flask
from flask_cors import CORS,cross_origin
from flask import request
import json

class Recommendation:
	def __init__(self):
		self.books = pd.read_csv('./books.csv', encoding='ISO-8859-1')
		ratings = pd.read_csv('./ratings.csv', encoding = "ISO-8859-1")
		book_tags = pd.read_csv('./book_tags.csv', encoding = "ISO-8859-1")
		tags = pd.read_csv('./tags.csv')
		tags_join_DF = pd.merge(book_tags, tags, left_on='tag_id', right_on='tag_id', how='inner')
		to_read = pd.read_csv('./to_read.csv')
		# tf = TfidfVectorizer(analyzer='word',ngram_range=(1, 2),min_df=0, stop_words='english')
		# tfidf_matrix = tf.fit_transform(self.books['authors'])
		# self.cosine_sim = linear_kernel(tfidf_matrix, tfidf_matrix)
		self.titles = self.books['title']
		books_with_tags = pd.merge(self.books, tags_join_DF, left_on='book_id', right_on='goodreads_book_id', how='inner')
		# tf1 = TfidfVectorizer(analyzer='word',ngram_range=(1, 2),min_df=0, stop_words='english')
		# tfidf_matrix1 = tf1.fit_transform(books_with_tags['tag_name'].head(10000))
		# self.cosine_sim1 = linear_kernel(tfidf_matrix1, tfidf_matrix1)
		temp_df = books_with_tags.groupby('book_id')['tag_name'].apply(' '.join).reset_index()
		self.books = pd.merge(self.books, temp_df, left_on='book_id', right_on='book_id', how='inner')
		self.books['corpus'] = (pd.Series(self.books[['authors', 'tag_name']]
						.fillna('')
						.values.tolist()
						).str.join(' '))
		tf_corpus = TfidfVectorizer(analyzer='word',ngram_range=(1, 2),min_df=0, stop_words='english')
		tfidf_matrix_corpus = tf_corpus.fit_transform(self.books['corpus'])
		self.cosine_sim_corpus = linear_kernel(tfidf_matrix_corpus, tfidf_matrix_corpus)

	# Function that get book recommendations based on the cosine similarity score of book authors
	# def authors_recommendations(self, title):
	# 	indices = pd.Series(self.books.index, index=self.books['title'])
	# 	idx = indices[title]
	# 	sim_scores = list(enumerate(self.cosine_sim[idx]))
	# 	sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)
	# 	sim_scores = sim_scores[1:21]
	# 	book_indices = [i[0] for i in sim_scores]
	# 	return self.titles.iloc[book_indices]

    # Function that get book recommendations based on the cosine similarity score of books tags
	# def tags_recommendations(self, title):
	# 	indices1 = pd.Series(self.books.index, index=self.books['title'])
	# 	idx = indices1[title]
	# 	sim_scores = list(enumerate(self.cosine_sim1[idx]))
	# 	sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)
	# 	sim_scores = sim_scores[1:21]
	# 	book_indices = [i[0] for i in sim_scores]
	# 	return self.titles.iloc[book_indices]

	# Function that get book recommendations based on the cosine similarity score of books tags
	# def corpus_recommendations(self, title):
	# 	indices1 = pd.Series(self.books.index, index=self.books['title'])
	# 	idx = indices1[title]
	# 	sim_scores = list(enumerate(self.cosine_sim_corpus[idx]))
	# 	sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)
	# 	sim_scores = sim_scores[1:21]
	# 	book_indices = [i[0] for i in sim_scores]
	# 	return self.titles.iloc[book_indices]


	def corpus_recommendations_byid(self, idx):
		sim_scores = list(enumerate(self.cosine_sim_corpus[idx]))
		sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)
		sim_scores = sim_scores[1:21]
		book_indices = [i[0] for i in sim_scores]
		return self.books.iloc[book_indices]

# Routes
app = Flask(__name__)
CORS(app, support_credentials=True)
recommender = Recommendation()

@app.route('/book/<book>')
def get_recommendation(book):
	dic = recommender.corpus_recommendations_byid(int(book)-1).fillna(0).drop('tag_name', 1)
	dic1 = dic.drop('corpus', 1)
	dic2 = dic1.to_dict(orient='records')
	obj = json.dumps(dic2)
	return obj

@app.route('/book/search')
def search_book():
	book = request.args.get('q')
	b = book.split()
	pattern = '|'.join(b)
	dic1 = recommender.books[recommender.books['title'].str.contains(pattern)].drop(['corpus', 'tag_name'], 1).fillna(0)
	dic2 = dic1.to_dict(orient='records')
	obj = json.dumps(dic2)
	return obj

@app.route('/book/recommend', methods=['POST'])
def recommend_book():
	if request.method == 'POST':
		genre = request.form['answers']
		g = json.loads(genre)
		ge = g
		pattern = '|'.join(ge)
		dic1 = recommender.books[recommender.books['corpus'].str.contains(pattern)].drop(['corpus', 'tag_name'], 1).fillna(0).iloc[:8]
		dic2 = dic1.to_dict(orient='records')
		obj = json.dumps(dic2)
		return obj


@app.route('/book/recommend/list', methods=['POST'])
def recommend_book():
	if request.method == 'POST':
		genre = request.form['answers']
		g = json.loads(genre)
		ge = g
		pattern = '|'.join(ge)
		dic1 = recommender.books[recommender.books['corpus'].str.contains(pattern)].drop(['corpus', 'tag_name'], 1).fillna(0)
		dic2 = dic1.to_dict(orient='records')
		obj = json.dumps(dic2)
		return obj


def run_app():
	if __name__ == '__main__':
		app.run(port=5001)


run_app()
