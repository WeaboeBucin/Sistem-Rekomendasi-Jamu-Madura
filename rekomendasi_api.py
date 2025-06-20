from flask import Flask, request, jsonify
import numpy as np
import pandas as pd
import gensim
import re
from keras.models import load_model
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
import pickle

app = Flask(__name__)

# Load komponen
model = load_model('modelsmote/best_bilstm_model.h5')
w2v_model = gensim.models.Word2Vec.load('modelsmote/word2vec_skipgram.model')
with open("modelsmote/label_encoder.pkl", "rb") as f:
    label_encoder = pickle.load(f)

# Dataset referensi
jamu_df = pd.read_pickle("modelsmote/jamu_database_vectors.pkl")  # pastikan ada vektor per jamu
STOPWORDS = set(stopwords.words('indonesian'))
MAX_LEN = 44
VECTOR_DIM = 100

def preprocess_text(text):
    text = text.lower()
    text = re.sub(r'[^a-zA-Z\s]', '', text)
    tokens = word_tokenize(text)
    filtered = [t for t in tokens if t not in STOPWORDS]
    return filtered

def convert_tokens_to_vectors(tokens_list, w2v_model, max_len, vector_dim):
    vectors = []
    for tokens in tokens_list:
        sequence = []
        for token in tokens[:max_len]:
            if token in w2v_model.wv:
                sequence.append(w2v_model.wv[token])
            else:
                sequence.append(np.zeros(vector_dim))
        while len(sequence) < max_len:
            sequence.append(np.zeros(vector_dim))
        vectors.append(sequence)
    return np.array(vectors)

def average_vector(vector_sequence):
    return np.mean(vector_sequence, axis=1)

@app.route('/rekomendasi-jamu', methods=['POST'])
def rekomendasi():
    data = request.get_json()
    input_text = data.get('text', '')

    tokens = preprocess_text(input_text)
    input_vector_seq = convert_tokens_to_vectors([tokens], w2v_model, MAX_LEN, VECTOR_DIM)
    pred_category_vector = model.predict(input_vector_seq)
    pred_category_index = np.argmax(pred_category_vector)
    pred_category_label = label_encoder.inverse_transform([pred_category_index])[0]

    # Ambil vektor rata-rata input
    input_avg_vector = average_vector(input_vector_seq)[0]  # shape: (100,)

    # Filter jamu dengan kategori yang sama
    subset_df = jamu_df[jamu_df['KATEGORI'] == pred_category_label]

    # Hitung Euclidean distance antara input dan semua jamu pada kategori itu
    def euclidean(vec1, vec2):
        return np.linalg.norm(vec1 - vec2)

    subset_df['distance'] = subset_df['avg_vector'].apply(lambda x: euclidean(input_avg_vector, x))

    top3 = subset_df.nsmallest(5, 'distance')

    # Format hasil
    recommendations = []
    for _, row in top3.iterrows():
        recommendations.append({
            'NAMA_JAMU': row['NAMA JAMU'],
            'PRODUSEN': row['PRODUSEN'],
            'skor': float(1 / (1 + row['distance']))  # dibalik agar skor tinggi = lebih dekat
        })

    return jsonify({
        'input': input_text,
        'predicted_category': pred_category_label,
        'recommendations': recommendations
    })

if __name__ == '__main__':
    app.run(port=5000)