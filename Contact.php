<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>SriHari: Contact</title>
    <!-- <link rel="stylesheet" href="alpha.css"> -->
    <link rel="stylesheet" href="Contact.css">
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
                <li class="nav-item active">
                    <a class="nav-link" href="Contact.php">Contact <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="project.php">Projects</a>
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

    <main class="main">
        <section id="contact" class="contact">
            <div class="section-heading text-center">
                <h2>contact me</h2>
            </div>
            <div class="container">
                <div class="contact-content">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-5 col-sm-6">
                            <div class="single-contact-box">
                                <div class="contact-form">
                                    <form id="contactForm" method="POST" action="process_contact.php">
                                        <div class="row">
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="name">Name:</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Name*" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="email">Email:</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        placeholder="Email*" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="subject">Subject:</label>
                                                    <input type="text" class="form-control" id="subject" name="subject"
                                                        placeholder="Subject">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="message">Message:</label>
                                                    <textarea class="form-control" rows="8" id="message" name="message"
                                                        placeholder="Message*" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="single-contact-btn">
                                                    <button type="submit" class="contact-btn">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div><!--/.contact-form-->
                            </div><!--/.single-contact-box-->
                        </div><!--/.col-->
                        <div class="col-md-offset-1 col-md-5 col-sm-6">
                            <div class="single-contact-box">
                                <div class="contact-adress">
                                    <div class="contact-add-head">
                                        <h3>Harishankar Chaturvedi</h3>
                                        <p>Data Analyst</p>
                                    </div>
                                    <div class="contact-add-info">
                                        <div class="single-contact-add-info">
                                            <h3>phone</h3>
                                            <p><a href="tel:+918354006149">+91 8354006149</a></p>
                                        </div>
                                        <div class="single-contact-add-info">
                                            <h3>email</h3>
                                            <p><a href="mailto:analysthari@gmail.com">analysthari@gmail.com</a></p>
                                        </div>
                                        <div class="single-contact-add-info">
                                            <h3>website</h3>
                                            <p>www.srihari.com</p>
                                        </div>
                                    </div>
                                </div><!--/.contact-adress-->
                                <div class="hm-foot-icon">
                                    <ul>
                                        <li><a href="#"><i class="fa-brands fa-instagram fa-2xl"></i></i></a></li>
                                        <!--/li-->
                                        <li><a href="#"><i class="fa-brands fa-whatsapp fa-2xl"></i></a></li><!--/li-->
                                        <li><a href="#"><i class="fa-brands fa-twitter fa-2xl"></i></a></li><!--/li-->
                                        <li><a href="#"><i class="fa-brands fa-linkedin fa-2xl"></i></a></li><!--/li-->
                                        <li><a href="#"><i class="fa-brands fa-facebook fa-2xl"></i></a></li><!--/li-->
                                    </ul><!--/ul-->
                                </div><!--/.hm-foot-icon-->
                            </div><!--/.single-contact-box-->
                        </div><!--/.col-->
                    </div><!--/.row-->
                </div><!--/.contact-content-->
            </div><!--/.container-->

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

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="Contact_Script.js" crossorigin="anonymous"></script>
</body>

</html>