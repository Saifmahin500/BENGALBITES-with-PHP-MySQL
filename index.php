<?php
require_once 'partials/header.php';
require_once 'partials/navbar.php';
?>

<style>
:root {
  --primary-color: #173831;
  --secondary-color: #DBF0DD;
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(23, 56, 49, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
}

.hero-content {
  text-align: center;
  color: white;
  z-index: 2;
}

.hero-content h1 {
  font-size: 3.5rem;
  font-weight: bold;
  margin-bottom: 1rem;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.hero-content p {
  font-size: 1.2rem;
  margin-bottom: 2rem;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.btn-primary-custom {
  color: white;
  background-color: var(--primary-color);
  border-color: var(--primary-color);
  padding: 12px 30px;
  font-weight: 600;
  border-radius: 25px;
  transition: all 0.3s ease;
}

.btn-primary-custom:hover {
  background-color:#98CB19;
  border-color: #0f251f;
  transform: translateY(-2px);
}

.section-title {
  color: var(--primary-color);
  font-weight: bold;
  margin-bottom: 3rem;
  position: relative;
  display: inline-block;
}

.section-title::after {
  content: '';
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 60px;
  height: 3px;
  background-color: var(--secondary-color);
}

.feature-card {
  background: white;
  border: none;
  border-radius: 15px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
  transition: transform 0.3s ease;
  overflow: hidden;
  height: 100%;
}

.feature-card:hover {
  transform: translateY(-10px);
}

.feature-icon {
  width: 80px;
  height: 80px;
  background-color: var(--secondary-color);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  font-size: 2rem;
  color: var(--primary-color);
}

.about-section {
  background-color: var(--secondary-color);
  padding: 80px 0;
}

.chef-image {
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.stats-section {
  background-color: var(--primary-color);
  color: white;
  padding: 60px 0;
}

.stat-item {
  text-align: center;
}

.stat-number {
  font-size: 3rem;
  font-weight: bold;
  display: block;
}

.stat-label {
  font-size: 1.1rem;
  opacity: 0.9;
}

.testimonial-card {
  background: white;
  border-radius: 15px;
  padding: 2rem;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
  margin-bottom: 2rem;
}

.testimonial-rating {
  color: #ffc107;
  margin-bottom: 1rem;
}

.cta-section {
  background: linear-gradient(135deg, var(--primary-color), #0f251f);
  color: white;
  padding: 80px 0;
  text-align: center;
}

.carousel-item {
  position: relative;
  height: 70vh;
}

.carousel-item img {
  height: 100%;
  object-fit: cover;
}
</style>

<div class="container-fluid p-0">
  <!-- Hero Section -->
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"  class="d-block w-100"alt="Restaurant Hero">
        <div class="hero-overlay">
          <div class="hero-content">
            <h1 class="display-4">Welcome to Our Restaurant</h1>
            <p class="lead">Experience the finest cuisine with fresh ingredients and authentic flavors</p>
            <!-- <a href="#menu" class="btn btn-primary-custom btn-lg">View Menu</a> -->
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="https://images.unsplash.com/photo-1687945512099-400cbe94460c?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100" alt="Restaurant Interior">
        <div class="hero-overlay">
          <div class="hero-content">
            <h1 class="display-4">Elegant Dining Experience</h1>
            <p class="lead">Perfect ambiance for your special moments</p>
            <!-- <a href="#reservation" class="btn btn-primary-custom btn-lg">Make Reservation</a> -->
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" class="d-block w-100" alt="Delicious Food">
        <div class="hero-overlay">
          <div class="hero-content">
            <h1 class="display-4">Crafted with Passion</h1>
            <p class="lead">Every dish tells a story of tradition and innovation</p>
            <!-- <a href="#about" class="btn btn-primary-custom btn-lg">Our Story</a> -->
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </button>
  </div>
</div>

<!-- Features Section -->
<div class="container mt-5 mb-5">
  <div class="text-center mb-5">
    <h2 class="section-title">Why Choose Us</h2>
    <p class="text-muted">Discover what makes our restaurant special</p>
  </div>
  
  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="feature-card p-4 text-center h-100">
        <div class="feature-icon">
          🍽️
        </div>
        <h4 class="mb-3" style="color: var(--primary-color);">Fresh Ingredients</h4>
        <p class="text-muted">We source only the finest, freshest ingredients from local farmers and trusted suppliers to ensure exceptional quality in every dish.</p>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="feature-card p-4 text-center h-100">
        <div class="feature-icon">
          👨‍🍳
        </div>
        <h4 class="mb-3" style="color: var(--primary-color);">Expert Chefs</h4>
        <p class="text-muted">Our talented culinary team brings years of experience and passion, creating memorable dishes that blend tradition with innovation.</p>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="feature-card p-4 text-center h-100">
        <div class="feature-icon">
          🏆
        </div>
        <h4 class="mb-3" style="color: var(--primary-color);">Award Winning</h4>
        <p class="text-muted">Recognized for excellence in cuisine and service, we're proud to be your neighborhood's premier dining destination.</p>
      </div>
    </div>
  </div>
</div>

<!-- About Section -->
<div class="about-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1977&q=80" alt="Head Chef" class="chef-image img-fluid">
      </div>
      <div class="col-lg-6">
        <h2 class="section-title">Our Story</h2>
        <p class="lead mb-4">For over two decades, we've been serving our community with passion, dedication, and an unwavering commitment to culinary excellence.</p>
        <p class="mb-4">What started as a small family restaurant has grown into a beloved dining destination, but our core values remain unchanged: quality ingredients, authentic flavors, and warm hospitality that makes every guest feel like family.</p>
        <p class="mb-4">Our head chef, with over 15 years of international experience, leads a talented kitchen team that takes pride in creating dishes that not only satisfy your hunger but create lasting memories.</p>
        <a href="#menu" class="btn btn-primary-custom">Explore Our Menu</a>
      </div>
    </div>
  </div>
</div>

<!-- Stats Section -->
<div class="stats-section">
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-6 mb-4">
        <div class="stat-item">
          <span class="stat-number">500+</span>
          <span class="stat-label">Happy Customers Daily</span>
        </div>
      </div>
      <div class="col-md-3 col-6 mb-4">
        <div class="stat-item">
          <span class="stat-number">25+</span>
          <span class="stat-label">Years of Experience</span>
        </div>
      </div>
      <div class="col-md-3 col-6 mb-4">
        <div class="stat-item">
          <span class="stat-number">150+</span>
          <span class="stat-label">Menu Items</span>
        </div>
      </div>
      <div class="col-md-3 col-6 mb-4">
        <div class="stat-item">
          <span class="stat-number">5★</span>
          <span class="stat-label">Average Rating</span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container mt-5">
  <!-- Products Section (Your existing section) -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="section-title">Our Products</h2>
    
  </div>
  <!-- Products Grid -->
  <div id="productGrid" class="row mb-5"></div>

  <!-- Customer Reviews -->
  <div class="text-center mb-5">
    <h2 class="section-title">What Our Customers Say</h2>
    <p class="text-muted">Read authentic reviews from our valued guests</p>
  </div>
  
  <div class="row mb-5">
    <div class="col-md-4">
      <div class="testimonial-card">
        <div class="testimonial-rating">
          ⭐⭐⭐⭐⭐
        </div>
        <p class="mb-3">"Absolutely amazing food and service! The flavors are incredible and the atmosphere is perfect for a romantic dinner. Will definitely be back!"</p>
        <div class="d-flex align-items-center">
          <img src="https://images.unsplash.com/photo-1494790108755-2616b612b637?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=387&q=80" alt="Customer" class="rounded-circle me-3" width="50" height="50">
          <div>
            <strong>Sarah Johnson</strong>
            <br>
            <small class="text-muted">Regular Customer</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="testimonial-card">
        <div class="testimonial-rating">
          ⭐⭐⭐⭐⭐
        </div>
        <p class="mb-3">"Best restaurant in town! The staff is friendly, food is always fresh, and the prices are very reasonable. My family's favorite spot!"</p>
        <div class="d-flex align-items-center">
          <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Customer" class="rounded-circle me-3" width="50" height="50">
          <div>
            <strong>Mike Chen</strong>
            <br>
            <small class="text-muted">Food Blogger</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="testimonial-card">
        <div class="testimonial-rating">
          ⭐⭐⭐⭐⭐
        </div>
        <p class="mb-3">"Outstanding culinary experience! Each dish is a masterpiece. The chef really knows how to balance flavors perfectly."</p>
        <div class="d-flex align-items-center">
          <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Customer" class="rounded-circle me-3" width="50" height="50">
          <div>
            <strong>Emma Davis</strong>
            <br>
            <small class="text-muted">Local Resident</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Call to Action Section -->
<div class="cta-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 mx-auto">
        <h2 class="display-4 mb-4">Ready to Dine With Us?</h2>
        <p class="lead mb-4">Book your table now and experience the perfect blend of exceptional cuisine, warm hospitality, and unforgettable moments.</p>
        <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
          <a href="tel:+1234567890" class="btn btn-outline-light btn-lg px-5">Call Now</a>
          <!-- <a href="#reservation" class="btn btn-outline-light btn-lg px-5">Make Reservation</a> -->
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'partials/footer.php'; ?>

<script>
// Auto-advance carousel every 5 seconds
$(document).ready(function(){
  $('#carouselExampleIndicators').carousel({
    interval: 5000
  });
});
</script>