<?php
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/navbar.php';
require_once __DIR__ . '/config/dbconfig.php';

$flag = $_GET['msg'] ?? '';

?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<style>
    .brand-primary {
        color: #173831 !important;
    }

    .brand-secondary {
        color: #DBF0DD !important;
    }

    .bg-brand-primary {
        background-color: #173831 !important;
    }

    .bg-brand-secondary {
        background-color: #DBF0DD !important;
    }

    .btn-brand {
        background-color: #173831;
        border-color: #173831;
        color: #DBF0DD;
    }

    .btn-brand:hover {
        background-color: #0f2a24;
        border-color: #0f2a24;
        color: #DBF0DD;
    }

    .card-custom {
        background: linear-gradient(135deg, #DBF0DD 0%, rgba(219, 240, 221, 0.8) 100%);
        border: 2px solid #173831;
    }

    .form-control:focus {
        border-color: #173831;
        box-shadow: 0 0 0 0.2rem rgba(23, 56, 49, 0.25);
    }

    .contact-icon {
        color: #173831;
        font-size: 1.2rem;
    }

    .map-container {
        border: 3px solid #173831;
        border-radius: 0.5rem;
        overflow: hidden;
    }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card shadow-lg border-0 card-custom">
                <div class="card-body p-4">
                    <h3 class="mb-4 font-weight-bold brand-primary">
                        <i class="fa-solid fa-envelope mr-3"></i> Contact Us
                    </h3>

                    <?php if ($flag === 'ok'):  ?>
                        <div class="alert alert-success border-0 shadow-sm">
                            <i class="fas fa-check-circle mr-2"></i>
                            <strong>Success!</strong> Your message has been submitted successfully.
                        </div>
                    <?php elseif ($flag === 'err'):  ?>
                        <div class="alert alert-danger border-0 shadow-sm">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Error!</strong> Something went wrong, please try again.
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="save_contact.php" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label class="form-label font-weight-semibold brand-primary">
                                <i class="fas fa-user mr-2"></i>Your Name
                            </label>
                            <input type="text" name="name" class="form-control form-control-lg border-2"
                                placeholder="Enter your full name" required>
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle mr-1"></i>Name is required.
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-semibold brand-primary">
                                <i class="fas fa-envelope mr-2"></i>Email Address
                            </label>
                            <input type="email" name="email" class="form-control form-control-lg border-2"
                                placeholder="your.email@example.com" required>
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle mr-1"></i>Valid email is required.
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-semibold brand-primary">
                                <i class="fas fa-tag mr-2"></i>Subject
                            </label>
                            <input type="text" name="subject" class="form-control form-control-lg border-2"
                                placeholder="What is this about?" required>
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle mr-1"></i>Enter your subject.
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-semibold brand-primary">
                                <i class="fas fa-comment mr-2"></i>Message
                            </label>
                            <textarea name="message" rows="5" class="form-control border-2"
                                placeholder="Write your message here..." required></textarea>
                            <div class="invalid-feedback">
                                <i class="fas fa-times-circle mr-1"></i>Message cannot be empty.
                            </div>
                        </div>

                        <button class="btn btn-brand btn-lg font-weight-bold px-5 py-3 shadow">
                            <i class="fas fa-paper-plane mr-2"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow border-0 mb-4" style="border: 2px solid #173831 !important;">
                <div class="card-header bg-brand-primary text-center py-3">
                    <h4 class="mb-0 font-weight-bold" style="color: #DBF0DD;">
                        <i class="fas fa-building mr-2"></i> Our Office
                    </h4>
                </div>
                <div class="card-body p-4 bg-light">
                    <div class="mb-3 d-flex align-items-start">
                        <i class=" fa-location-dot contact-icon mr-3 mt-1"></i>
                        <div>
                            <strong class="brand-primary">Address:</strong><br>
                            <span class="text-muted">29 Purana Paltan, Noorjahan Sharif Plaza</span>
                        </div>
                    </div>

                    <div class="mb-3 d-flex align-items-center">
                        <i class="fa-solid fa-phone contact-icon mr-3"></i>
                        <div>
                            <strong class="brand-primary">Phone:</strong>
                            <a href="tel:+8801856590532" class="text-decoration-none ml-2">
                                +88 01856-590532
                            </a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-envelope contact-icon mr-3"></i>
                        <div>
                            <strong class="brand-primary">Email:</strong>
                            <a href="mailto:info@BengalBites.com" class="text-decoration-none ml-2">
                                info@BengalBites.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Google Map Embed -->
            <div class="card shadow border-0">
                <div class="card-header bg-brand-primary text-center py-2">
                    <h5 class="mb-0 font-weight-bold" style="color: #DBF0DD;">
                        <i class="fas fa-map-marker-alt mr-2"></i> Find Us Here
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d112256.41077283815!2d90.29221158983356!3d23.7967209321402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b96ad177ac5b%3A0x7ea0275cf8228b81!2sNur%20jahan%20sharif%20plaza!5e1!3m2!1sen!2sbd!4v1755585807624!5m2!1sen!2sbd"
                            width="100%"
                            height="280"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function() {
        'use strict';
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>