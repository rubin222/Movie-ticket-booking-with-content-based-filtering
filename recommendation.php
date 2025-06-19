<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Recommendation System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .movie {
            margin: 10px;
            display: inline-block;
            text-align: left;
            width: 200px;
        }
        .movie img {
            width: 100%;
            height: auto;
        }
        .movie h3 {
            font-size: 16px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>Movie Recommendation System</h1>
    <input type="text" id="movieName" placeholder="Enter movie name">
    <button onclick="getRecommendations()">Get Recommendations</button>

    <div id="recommendations"></div>

    <script>
        function getRecommendations() {
            const movieName = document.getElementById("movieName").value;
            fetch('YOUR_NGROK_URL/recommend', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'movie_name=' + movieName,
            })
            .then(response => response.json())
            .then(data => {
                const recommendationsDiv = document.getElementById("recommendations");
                recommendationsDiv.innerHTML = '';
                data.forEach(movie => {
                    const movieDiv = document.createElement('div');
                    movieDiv.className = 'movie';
                    movieDiv.innerHTML = `
                        <img src="https://via.placeholder.com/150" alt="${movie.title}">
                        <h3>${movie.title}</h3>
                        <p>${movie.overview}</p>
                    `;
                    recommendationsDiv.appendChild(movieDiv);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>
