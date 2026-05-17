<?php
require_once __DIR__ . '/../../app/middleware/AuthMiddleware.php';
Auth::gate();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: ../assets/movies.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vesper - Add Movie</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

<style>

body{
background:#08080a;
color:white;
font-family:'Outfit',sans-serif;
}

.wrapper{
max-width:900px;
margin:auto;
padding-top:100px;
padding-bottom:50px;
}

.top-bar{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:40px;
}

.page-title{
font-family:'Cormorant Garamond';
font-size:3rem;
margin:0;
}

.back-btn{
text-decoration:none;
padding:10px 20px;
border:1px solid #2d4d7a;
background:#162133;
color:#8eb8ff;
font-size:10px;
letter-spacing:.18em;
text-transform:uppercase;
transition:.2s;
}

.back-btn:hover{
background:#1d2b42;
color:#c3dcff;
}

.panel{
background:#101014;
border:1px solid #222;
padding:35px;
}

.form-control{
background:#0d0d10;
border:1px solid #2a2a2a;
color:white;
padding:14px;
}

.form-control:focus{
background:#0d0d10;
color:white;
border-color:#555;
box-shadow:none;
}

textarea{
height:120px;
resize:none;
}

label{
margin-bottom:10px;
font-size:.8rem;
letter-spacing:2px;
color:#888;
}

.submit-btn{
width:100%;
padding:14px;
background:#4ade80;
border:none;
color:#08110c;
font-weight:600;
letter-spacing:.12em;
text-transform:uppercase;
margin-top:20px;
transition:.2s;
}

.submit-btn:hover{
background:#65f09a;
}

.review-box{
background:#101014;
border:1px solid #222;
padding:20px;
margin-top:30px;
}

.review-title{
margin-bottom:20px;
font-family:'Cormorant Garamond';
}

</style>
</head>

<body>

<div class="container wrapper">

<div class="top-bar">

<div>
<p style="color:#777;margin-bottom:5px;">
ADMIN PANEL
</p>

<h1 class="page-title">
Add Movie
</h1>
</div>

<a href="admin.php" class="back-btn">
← Back
</a>

</div>


<div class="panel">

<form action="../../app/controllers/admin/addMovie.php"
method="POST"
enctype="multipart/form-data">

<div class="row">

<div class="col-md-6 mb-4">

<label>MOVIE TITLE</label>

<input
type="text"
name="title"
class="form-control"
placeholder="Fight Club"
required>

</div>

<div class="col-md-6 mb-4">

<label>TMDB ID</label>

<input
type="number"
name="tmdb_id"
class="form-control"
placeholder="550"
required>

</div>


<div class="col-12 mb-4">

<label>OVERVIEW</label>

<textarea
name="overview"
class="form-control"
placeholder="Write movie description..."></textarea>

</div>


<div class="col-md-6 mb-4">

<label>RELEASE DATE</label>

<input
type="date"
name="release_date"
class="form-control">

</div>


<div class="col-md-6 mb-4">

<label>GENRE IDS</label>

<input
type="text"
name="genre_ids"
class="form-control"
placeholder="28,18,53">

</div>


<div class="col-md-6 mb-4">

<label>POSTER IMAGE</label>

<input
type="file"
name="poster"
class="form-control"
accept="image/*">

</div>


<div class="col-md-3 mb-4">

<label>RATING</label>

<input
type="number"
step="0.1"
name="vote_average"
class="form-control"
placeholder="8.9">

</div>


<div class="col-md-3 mb-4">

<label>VOTE COUNT</label>

<input
type="number"
name="vote_count"
class="form-control"
placeholder="1200">

</div>

</div>

<button class="submit-btn">
ADD MOVIE
</button>

</form>

</div>

</div>

</body>
</html>