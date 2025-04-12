<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>SriHari: Projects</title>
    <link rel="stylesheet" href="project.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-pen-fancy fa-xl"></i>SriHari</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="project.php">Projects <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="study_material.php">Study Materials</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <main class="projects-main">
        <div class="container">
            <h2 class="section-title">My Projects</h2>
            <div class="projects-grid" id="projects-container">
                <!-- Projects will be loaded here via JavaScript -->
                <div class="loading">Loading projects...</div>
            </div>
        </div>
    </main>
    <footer class="footer">
        <section class="footerupper">
            <div class="left">
                <ul type="None">
                    <li>
                        <p1>Contact Information</p1>
                    </li>
                    <li>Contact Me: <a href="tel:+918354006149">8354006149</a></li>
                    <li>Mail Me:<a href="haribhuofficial@gmail.com">haribhuofficial@gmail.com</a></li>
                    <li>
                        <Address>72 MIG Jawahar Puram phase-I</Address>
                    </li>
                    <li>
                        <Address>Aldwatiya Road Shahganj Agra</Address>
                    </li>
                </ul>
            </div>
            <div class="middle">
                <p1>© 2025 Harishankar Chaturvedi.</p1>
                <p2>All rights reserved.</p2>
            </div>
            <div class="right">
                <ul type="None">
                    <li>Quick Link</li>
                    <li><a href="">Resume</a></li>
                    <li><a href="">Projects</a></li>
                    <li><a href="">Experience</a></li>
                </ul>
            </div>
        </section>
        <div class="bottom">
            <ul type="None">
                <li><i class="fa-brands fa-github fa-2xl"></i><a href="">My Git</a></li>
                <li><i class="fa-brands fa-instagram fa-2xl"></i><a href="">Instagram</a></li>
                <li><i class="fa-brands fa-whatsapp fa-2xl"></i><a href="">WhatsApp</a></li>
                <li><i class="fa-brands fa-kaggle fa-2xl"></i><a href="">Kaggle</a></li>
            </ul>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="project.js"></script>
</body>

</html>