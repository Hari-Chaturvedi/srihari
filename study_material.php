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
    <!-- <link rel="stylesheet" href="alpha.css"> -->
    <link rel="stylesheet" href="study_material.css">
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
                    <a class="nav-link" href="project.php">Projects <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="services.php">Services</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="study_material.php">Study Materials</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <main class="study-materials">
        <!-- Hero Section -->
        <section class="study-hero">
            <div class="container">
                <h1 class="hero-title">Data Science Study Materials</h1>
                <p class="hero-subtitle">Master the fundamentals of Data Analytics & Machine Learning</p>
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search topics...">
                    <button id="searchButton"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="categories">
            <div class="container">
                <h2 class="section-title">Browse by Category</h2>
                <div class="category-grid">
                    <div class="category-card" style="background-color: #3498db;" data-category="statistics">
                        <i class="fas fa-calculator"></i>
                        <h3>Statistics</h3>
                    </div>
                    <div class="category-card" style="background-color: #2ecc71;" data-category="sql">
                        <i class="fas fa-database"></i>
                        <h3>SQL</h3>
                    </div>
                    <div class="category-card" style="background-color: #e74c3c;" data-category="python">
                        <i class="fab fa-python"></i>
                        <h3>Python</h3>
                    </div>
                    <div class="category-card" style="background-color: #f39c12;" data-category="visualization">
                        <i class="fas fa-chart-line"></i>
                        <h3>Data Visualization</h3>
                    </div>
                    <div class="category-card" style="background-color: #9b59b6;" data-category="ml">
                        <i class="fas fa-brain"></i>
                        <h3>Machine Learning</h3>
                    </div>
                    <div class="category-card" style="background-color: #1abc9c;" data-category="projects">
                        <i class="fas fa-project-diagram"></i>
                        <h3>Projects</h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- Materials Section -->
        <section class="materials-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Latest Study Materials</h2>
                    <div class="filter-options">
                        <span>Sort by:</span>
                        <select id="sortSelect">
                            <option value="default">Default</option>
                            <option value="title-asc">Title (A-Z)</option>
                            <option value="title-desc">Title (Z-A)</option>
                            <option value="duration-asc">Duration (Shortest)</option>
                            <option value="duration-desc">Duration (Longest)</option>
                            <option value="level">Difficulty Level</option>
                        </select>
                    </div>
                </div>

                <div class="materials-grid" id="materialsGrid">


                </div>

                <div class="pagination">
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <a href="#">5</a>
                    <a href="#"><i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </section>

        <!-- Newsletter Section -->
        <section class="newsletter">
            <div class="container">
                <div class="newsletter-content">
                    <h2>Get New Materials Directly</h2>
                    <p>Subscribe to our newsletter and receive the latest study materials and tutorials.</p>
                    <form id="newsletterForm">
                        <div class="input-group">
                            <input type="email"
                                class="form-control"
                                name="email"
                                placeholder="Your email address"
                                required
                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <span class="btn-text">Subscribe</span>
                                </button>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            Please provide a valid email address.
                        </div>
                    </form>
                </div>
            </div>
        </section>
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
                    <li><a href="">
                            <Address>72 MIG Jawahar Puram phase-I</Address>
                        </a></li>
                    <li><a href="">
                            <Address>
                    <li><a href="">
                            <Address>Aldwatiya Road Shahganj Agra </Address>
                        </a></li>
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
                <li><i class="fa-brands fa-github fa-2xl"><a href="">My Git</a></i></li>
                <li><i class="fa-brands fa-instagram fa-2xl"><a href="">Instagram</a></i></li>
                <li><i class="fa-brands fa-whatsapp fa-2xl"><a href="">WhatsApp</a></i></li>
                <li><i class="fa-brands fa-kaggle fa-2xl"><a href="">Kaggle</a></i></li>

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
    <script src="study_material.js"></script>
</body>

</html>