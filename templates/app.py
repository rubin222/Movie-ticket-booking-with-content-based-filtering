from flask import Flask, render_template, request, jsonify
import pandas as pd
import re
import string
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

app = Flask(__name__)

# File paths (Modify this path if running locally)
file_paths = [
    "C:\\xampp\\htdocs\\nirjala\\tmdb_5000_movies.csv",  # Double backslashes
    "C:\\xampp\\htdocs\\nirjala\\Top_10000_Movies.csv",
    "C:\\xampp\\htdocs\\nirjala\\IMDB-Movie-Dataset(2023-1951).csv"
]

# Define possible column names
column_mapping = {
    "title": ["title", "original_title", "movie_name"],
    "genres": ["genres", "genre", "movie_genre"],
    "overview": ["overview"]
}

# Load and standardize datasets
dfs = []
for file_path in file_paths:
    try:
        df = pd.read_csv(file_path, encoding='utf-8', on_bad_lines='skip', engine='python')
        df.columns = df.columns.str.lower().str.strip()

        # Rename columns
        new_column_names = {}
        for standard_name, variations in column_mapping.items():
            for variation in variations:
                if variation in df.columns:
                    new_column_names[variation] = standard_name
                    break
        df.rename(columns=new_column_names, inplace=True)

        # Ensure required columns exist
        if all(col in df.columns for col in column_mapping.keys()):
            dfs.append(df)
    except Exception as e:
        print(f"Error loading {file_path}: {e}")

# Merge datasets
if not dfs:
    raise ValueError("No valid datasets found!")

df = pd.concat(dfs, ignore_index=True)

# Data preprocessing
def clean_text(text):
    text = str(text).lower()
    text = re.sub(f"[{string.punctuation}]", "", text)
    text = re.sub("\\d+", "", text)
    return text

df['title'] = df['title'].fillna("Unknown")
df['genres'] = df['genres'].fillna("Unknown")
df['overview'] = df['overview'].fillna("Unknown")
df['combined_features'] = df['title'] + " " + df['genres'] + " " + df['overview']
df['combined_features'] = df['combined_features'].apply(clean_text)

# Convert text to feature vectors
vectorizer = TfidfVectorizer(stop_words='english')
tfidf_matrix = vectorizer.fit_transform(df['combined_features'])

# Compute cosine similarity
cosine_sim = cosine_similarity(tfidf_matrix, tfidf_matrix)

# Movie recommendation function
def recommend_movies(movie_title, num_recommendations=5):
    if movie_title not in df['title'].values:
        return []
    
    idx = df.index[df['title'] == movie_title].tolist()[0]
    sim_scores = list(enumerate(cosine_sim[idx]))
    sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)[1:num_recommendations+1]
    movie_indices = [i[0] for i in sim_scores]

    return df['title'].iloc[movie_indices].tolist()

# Flask Routes
@app.route('/')
def index():
    return render_template('index1.html')

@app.route('/recommend', methods=['POST'])
def recommend():
    movie_name = request.form['movie_name']
    recommendations = recommend_movies(movie_name)
    return jsonify(recommendations)

if __name__ == '__main__':
    app.run(debug=True)
