<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// BASE URL জেনারেশন আরও সুরক্ষিতভাবে
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$BASE = defined('BASE_URL') ? BASE_URL : "{$protocol}://{$host}/PHP/BengalBites";

$isLoggedIn = !empty($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Account';

// যদি HTML এ আউটপুট করা হয়, স্যানিটাইজ করা
$userName = htmlspecialchars($userName, ENT_QUOTES, 'UTF-8');


$cartCount = 0;

try {
  require_once __DIR__ . '/../admin/dbConfig.php';

  if ($isLoggedIn && isset($DB_con)) {
    $uid = (int)$_SESSION['user_id'];

    $st = $DB_con->prepare("SELECT id FROM carts WHERE user_id = ? AND status = 'open' LIMIT 1");
    $st->execute([$uid]);

    $cartId = $st->fetch(PDO::FETCH_ASSOC)['id'] ?? null;

    if ($cartId) {
      $st = $DB_con->prepare("SELECT COALESCE(SUM(qty), 0) AS c FROM cart_items WHERE cart_id = ?");
      $st->execute([$cartId]);
      $cartCount = (int)($st->fetch(PDO::FETCH_ASSOC)['c'] ?? 0);
    }
  } else {
    if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
      foreach ($_SESSION['cart'] as $q) $cartCount += (int)$q;
    }
  }
} catch (Throwable $e) {
}


?>






<!-- Bootstrap 5 CSS & JS CDN  -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome CDN -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />


<style>
  body {
    font-family: 'Poppins', sans-serif;
    line-height: 1.6;
    color: #333;
  }

  /* Global Navbar Styles */
  .navbar {
    background: #DBF0DD !important;
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    padding: 0.8rem 1rem;
  }

  .navbar-brand {
    font-size: 1.5rem;
    font-weight: 700;
    color: #173831 !important;
    display: flex;
    align-items: center;
  }

  .navbar-brand i {
    color: #173831;
    margin-right: 8px;
  }

  /* Links */
  .navbar-nav .nav-link {
    font-weight: 500;
    color: #333 !important;
    margin: 0 10px;
    transition: color 0.3s ease;
  }

  .navbar-nav .nav-link:hover,
  .navbar-nav .nav-link.active {
    color: #173831 !important;
    font-weight: 600;
  }

  /* Active underline */
  .navbar-nav .nav-link.active::after {
    content: '';
    display: block;
    height: 2px;
    background: #173831;
    margin-top: 3px;
  }

  /* Search box */
  .navbar .form-control {
    border-radius: 25px;
    border: 1px solid #ccc;
  }

  .navbar .btn-search {
    border-radius: 50%;
    background: #173831;
    color: #fff;
  }

  .navbar .btn-search:hover {
    background: #2d5a4e;
  }

  /* Cart badge */
  #navCartCount {
    background: #173831;
    color: #fff;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    position: absolute;
    top: -6px;
    right: -8px;
  }

  /* Dropdown menu */
  .navbar .dropdown-menu {
    border-radius: 10px;
    border: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }


  /* Toggler (Bootstrap 5) */
  .navbar .navbar-toggler {
    border-color: var(--brand-dark) !important;
  }

  .navbar .navbar-toggler-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(23,56,49,1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E") !important;
  }
</style>




<nav class="navbar navbar-expand-lg shadow-sm fw-bold fixed-top" style="background-color: #DBF0DD;">
  <div class="container">
    <a class="navbar-brand fw-bold text-uppercase " style="color: #05010cff;" href="<?= $BASE ?>">
      <i class="fa-solid fa-utensils" style="color: #304f17;"></i> BENGALBITES

    </a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Left Menu -->
      <?php
      $current = basename($_SERVER['PHP_SELF']);
      $view    = $_GET['view'] ?? '';
      ?>
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?= $current === 'index.php' && $view === '' ? 'active' : '' ?>"
            style="color: #173831;" href="<?= $BASE ?>">
            Home
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?= $current === 'allMenu.php' ? 'active' : '' ?>"
            href="<?= $BASE ?>/allMenu.php">
            Our Menu
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?= $current === 'about.php' ? 'active' : '' ?>"
            href="<?= $BASE ?>/about.php">
            About Us
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?= $current === 'contact_us.php' ? 'active' : '' ?>"
            href="<?= $BASE ?>/contact_us.php">
            Contact Us
          </a>
        </li>
      </ul>


      <!-- Search Box -->
      <form class="d-flex me-3" role="search" action="search.php" method="get">
        <input
          class="form-control form-control-sm me-2"
          type="search"
          placeholder="Search products..."
          name="q"
          aria-label="Search" />
        <button class="btn btn-outline-light btn-sm" style="color: #7D3EE4;" type="submit">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>

      <!-- Cart & Auth Buttons -->
      <ul class="navbar-nav">
        <li class="nav-item me-3">
          <a class="nav-link position-relative " href="<?= $BASE ?>/cart.php" style="color: #7D3EE4;" title="View Cart">
            <i class="fa-solid fa-cart-shopping fs-5"></i>
            <span id="navCartCount" class="badge badge-pill badge-danger" style="position: absolute; top: 2px; transform: translate(50%, -50%); font-size: 11px; min-width: 18px;">
              <?= $cartCount ?>
            </span>
          </a>
        </li>
      </ul>

      <!-- login & registration -->

      <ul class="navbar-nav">
        <?php if ($isLoggedIn): ?>
          <li class="nav-item dropdown">
            <!-- User icon এবং username -->
            <a class="nav-link dropdown-toggle" href="#" id="accMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user-circle fs-5"></i> <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accMenu">
              <a class="dropdown-item" href="<?= $BASE ?>/auth/profile.php">
                <i class="fas fa-id-badge"></i> My Profile
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?= $BASE ?>/auth/logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <button class="nav-link btn btn-outline-light mr-2" data-bs-toggle="modal" data-bs-target="#loginModal">
              <i class="fa-solid fa-right-to-bracket"></i> Login
            </button>
          </li>
          <li class="nav-item">
            <button class="nav-link btn btn-outline-warning mr-2" data-bs-toggle="modal" data-bs-target="#registerModal">
              <i class="fa-solid fa-right-to-bracket"></i> Register
            </button>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<?php if (!$isLoggedIn): ?>
  <!--Login Modal-->
  <div class="modal fade" id="loginModal">
    <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content" method="post" action="<?= $BASE ?>/auth/login.php">
        <div class="modal-header">
          <h5 class="modal-title" id="loginTitle">Login to your account</h5>
          <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required autocomplete="email">
          </div>
          <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required autocomplete="current-password">
          </div>
          <small>
            <a href="<?= $BASE ?>/auth/fpass.php">Forgot Password?</a>
          </small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-dark">Login</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Register Modal -->
  <div class="modal fade" id="registerModal">
    <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content" method="post" action="<?= $BASE ?>/auth/register.php">
        <div class="modal-header">
          <h5 class="modal-title" id="registerTitle">Create an Account</h5>
          <button type="button" class="close" data-bs-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" required autocomplete="username">
          </div>

          <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class=" form-control" required autocomplete="email">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required autocomplete="new-password" minlength="6">
          </div>

          <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="cpassword" class="form-control" required autocomplete="new-password" minlength="6">
            <small class="text-muted">By creating an account, you agree to our terms.</small>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Register</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php endif; ?>

<script type="text/javascript">
  (function() {
    var nav = document.querySelector('.navbar.fixed-top') || document.querySelector('.navbar');
    if (!nav) return;

    function applyPad() {
      var h = nav.getBoundingClientRect().height;
      document.body.style.paddingTop = h + 'px';
    }
    window.addEventListener('load', applyPad);
    window.addEventListener('resize', applyPad);
  })();
  window.updateNavCartBadge = function(totalQty) {
    var badge = document.getElementById('navCartCount');
    if (!badge) return;
    badge.textContent = (parseInt(totalQty, 10) || 0);
  };
</script>