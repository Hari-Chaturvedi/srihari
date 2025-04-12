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
    <link rel="stylesheet" href="services.css">
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
                    <a class="nav-link" href="project.php">Projects</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="services.php">Services <span class="sr-only">(current)</a>
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

    <main class="services-main">
        <section class="services-hero">
            <div class="hero-content">
                <h1 class="hero-title animate__animated animate__fadeInDown">Data Analysis Services</h1>
                <p class="hero-subtitle animate__animated animate__fadeIn animate__delay-1s">Transforming raw data into
                    strategic insights</p>
            </div>
            <div class="hero-wave">
                <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path
                        d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                        opacity=".25" fill="#3498db"></path>
                    <path
                        d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                        opacity=".5" fill="#3498db"></path>
                    <path
                        d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                        fill="#3498db"></path>
                </svg>
            </div>
        </section>

        <section class="services-intro">
            <div class="container">
                <p class="intro-text animate__animated animate__fadeIn animate__delay-1s">
                    As a data analyst, I offer a comprehensive range of services to help businesses and individuals make
                    data-driven decisions.
                    My expertise includes data collection, processing, visualization, and advanced analytics.
                </p>
            </div>
        </section>

        <section class="services-grid">
            <div class="container">
                <!-- Service 1 -->
                <div class="service-card animate__animated animate__fadeInUp">
                    <div class="service-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="service-title">Data Collection & Cleaning</h3>
                    <ul class="service-features">
                        <li>Gathering data from various sources</li>
                        <li>Cleaning and preprocessing data</li>
                        <li>Handling missing values</li>
                        <li>Ensuring data integrity</li>
                    </ul>
                    <div class="service-hover">
                        <p>Let me handle your messy data and transform it into analysis-ready format</p>
                        <button class="btn-service">Learn More</button>
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="service-card animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="service-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="service-title">Exploratory Data Analysis</h3>
                    <ul class="service-features">
                        <li>Identifying trends and patterns</li>
                        <li>Statistical analysis</li>
                        <li>Outlier detection</li>
                        <li>Data visualization</li>
                    </ul>
                    <div class="service-hover">
                        <p>Discover hidden insights in your data through comprehensive exploration</p>
                        <button class="btn-service">Learn More</button>
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="service-card animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="service-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h3 class="service-title">Data Visualization</h3>
                    <ul class="service-features">
                        <li>Interactive dashboards</li>
                        <li>Custom reports</li>
                        <li>Power BI/Tableau</li>
                        <li>Data storytelling</li>
                    </ul>
                    <div class="service-hover">
                        <p>Transform numbers into compelling visual stories</p>
                        <button class="btn-service">Learn More</button>
                    </div>
                </div>

                <!-- Service 4 -->
                <div class="service-card animate__animated animate__fadeInUp">
                    <div class="service-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3 class="service-title">Predictive Analytics</h3>
                    <ul class="service-features">
                        <li>Machine learning models</li>
                        <li>Regression & classification</li>
                        <li>Forecasting</li>
                        <li>Model optimization</li>
                    </ul>
                    <div class="service-hover">
                        <p>Predict future trends and behaviors with advanced analytics</p>
                        <button class="btn-service">Learn More</button>
                    </div>
                </div>

                <!-- Service 5 -->
                <div class="service-card animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="service-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3 class="service-title">Business Intelligence</h3>
                    <ul class="service-features">
                        <li>Performance analysis</li>
                        <li>Strategic insights</li>
                        <li>KPI monitoring</li>
                        <li>Decision support</li>
                    </ul>
                    <div class="service-hover">
                        <p>Turn your business data into competitive advantage</p>
                        <button class="btn-service">Learn More</button>
                    </div>
                </div>

                <!-- Service 6 -->
                <div class="service-card animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="service-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="service-title">Database Management</h3>
                    <ul class="service-features">
                        <li>SQL queries</li>
                        <li>Database optimization</li>
                        <li>Data extraction</li>
                        <li>Relational databases</li>
                    </ul>
                    <div class="service-hover">
                        <p>Efficiently manage and extract value from your databases</p>
                        <button class="btn-service">Learn More</button>
                    </div>
                </div>

                <!-- Add remaining services following the same pattern -->
            </div>
        </section>

        <section class="services-cta">
            <div class="container">
                <h2 class="cta-title">Ready to unlock the power of your data?</h2>
                <p class="cta-text">Let's work together to turn your data into actionable knowledge!</p>
                <button class="btn-cta"><a class="btn-cta-link" href="Contact.php">Get Started Today</a></button>
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>