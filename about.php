<?php
require_once 'partials/header.php';
require_once 'partials/navbar.php';
?>


    <style>
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .hero-section {
            background: linear-gradient(rgba(21, 20, 20, 0.6), rgba(60, 59, 59, 0.6)), url('https://i.pinimg.com/1200x/25/86/f1/2586f159e6f76698af66efed04c88c4f.jpg');
            background-size: cover;
            background-position: center;
            height: 80vh;
            display: flex;
            align-items: center;
            color: white;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 3rem;
            position: relative;
            text-align: center;
        }

        .section-title::after {
            content: '';
            width: 60px;
            height: 3px;
            background: #173831;
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .story-section {
            padding: 100px 0;
            background: #f8f9fa;
        }

        .story-content {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 50px;
            margin-bottom: 50px;
        }

        .story-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 30px;
        }

        .chef-image {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .chef-image:hover {
            transform: translateY(-10px);
        }

        .values-section {
            padding: 100px 0;
            background: white;
        }

        .value-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            background: white;
        }

        .value-icon {
            font-size: 3rem;
            color: #173831;
            margin-bottom: 20px;
        }

        .value-card h4 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .value-card p {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
        }

        .team-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #173831 0%, #2d5a4e 100%);
            color: white;
        }

        .team-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.2);
        }

        .team-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #DBF0DD 0%, #a8d4ad 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #173831;
        }

        .team-card h5 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .team-card .position {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .achievements-section {
            padding: 100px 0;
            background: #BDE0C1;
            color: black;
        }

        .achievement-item {
            text-align: center;
            padding: 30px 20px;
        }

        .achievement-number {
            font-size: 3.5rem;
            font-weight: 700;
            color: black;
            margin-bottom: 10px;
        }

        .achievement-text {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .cta-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #173831 0%, #2d5a4e 100%);
            color: white;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .btn-custom {
            background: #DBF0DD;
            color: #173831;
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-custom:hover {
            background: rgba(219, 240, 221, 0.9);
            color: #173831;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

    
    </style>



    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content fade-in-up">
                <h1>Our Story</h1>
                <p class="lead">A unique blend of taste, tradition and love</p>
            </div>
        </div>
    </section>

    <!-- Story Section -->
    <section class="story-section">
        <div class="container">
            <h2 class="section-title fade-in-up">Our Journey</h2>
            <div class="row align-items-center">
                <div class="col-lg-6 fade-in-up">
                    <div class="story-content">
                        <p class="story-text">
                            <strong>Since 1995</strong>, we have been serving the taste of traditional Bengali food. Each of our dishes is prepared following old-fashioned recipes that will give you the taste of home-cooked food.
                        </p>
                        <p class="story-text">
                            With the expertise of our chefs and the use of fresh ingredients, every dish has exceptional taste and quality. We believe that food is not just for filling the stomach, but also for the satisfaction of the soul.
                        </p>
                        <p class="story-text">
                            <em>"Food is another name for love, and we mix that love into every dish."</em>
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 fade-in-up">
                    <img src="https://images.unsplash.com/photo-1583394293214-28ded15ee548?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fENoZWZ8ZW58MHx8MHx8fDA%3D"
                        alt="Head Chef" class="img-fluid chef-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section mb-4">
        <div class="container">
            <h2 class="section-title fade-in-up">Our Values</h2>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card fade-in-up">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4>Love & Care</h4>
                        <p>We work with infinite love and care in preparing every dish. Your satisfaction is our achievement.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card fade-in-up">
                        <div class="value-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4>Fresh Ingredients</h4>
                        <p>We use only fresh and high quality ingredients. Sourced directly from local farmers.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card fade-in-up">
                        <div class="value-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Family Environment</h4>
                        <p>You will find a family atmosphere in our restaurant. Every guest here is a member of our family.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section my-">
        <div class="container">
            <h2 class="section-title text-white fade-in-up">Our Team</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-card fade-in-up">
                        <div class="team-avatar">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h5>Abdul Karim</h5>
                        <p class="position">Head Chef</p>
                        <p>A magician of Bengali food with 20 years of experience.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-card fade-in-up">
                        <div class="team-avatar">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h5>Fatema Begum</h5>
                        <p class="position">Assistant Chef</p>
                        <p>Skilled and experienced in traditional Bengali cooking.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-card fade-in-up">
                        <div class="team-avatar">
                            <i class="fas fa-concierge-bell"></i>
                        </div>
                        <h5>Saif Uddin</h5>
                        <p class="position">Restaurant Manager</p>
                        <p>Dedicated and experienced professional </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-card fade-in-up">
                        <div class="team-avatar">
                            <i class="fas fa-coffee"></i>
                        </div>
                        <h5>Rahima Khatun</h5>
                        <p class="position">Beverage Specialist</p>
                        <p>Skilled in making tea, coffee and special drinks.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements Section -->
    <section class="achievements-section my-">
        <div class="container">
            <h2 class="section-title text-white fade-in-up">Our Achievements</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="achievement-item fade-in-up">
                        <div class="achievement-number">500+</div>
                        <div class="achievement-text">Happy Customers</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="achievement-item fade-in-up">
                        <div class="achievement-number">25+</div>
                        <div class="achievement-text">Years of Experience</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="achievement-item fade-in-up">
                        <div class="achievement-number">150+</div>
                        <div class="achievement-text">Special Dishes</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="achievement-item fade-in-up">
                        <div class="achievement-number">5⭐</div>
                        <div class="achievement-text">Average Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section">
        <div class="container">
            <div class="fade-in-up">
                <h2>Join Us Today!</h2>
                <p class="lead mb-4">Visit our restaurant today for an extraordinary taste experience</p>
                <a href="#contact" class="btn btn btn-custom">Call Now</a>
            </div>
        </div>
    </section>
    <?php require_once 'partials/footer.php'; ?>
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js">