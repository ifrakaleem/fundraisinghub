<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div class="logo">
        <img src="logo.jpg" alt="Donation Portal Logo">
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="dashboard.php">My Dashboard</a></li>
            <li><a href="index.php">Make a Donation</a></li>
            <li><a href="whatsnew.html">What's New</a></li>
            <li class="header-dropdown">
                <?php if(isset($_SESSION['username'])): ?>
                    <span class="signin-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <div class="header-dropdown-content">
                        <a href="userprofile.php">Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>
                <?php else: ?>
                    <span class="signin-text">Sign In</span>
                    <div class="header-dropdown-content">
                        <a href="userlogin.php">As Donor</a>
                        <a href="orglogin.php">As Organization</a>
                        <a href="adminlogin.php">As Administrator</a> 
                    </div>
                <?php endif; ?>
            </li>
            <li>
                <form action="search_results.php" method="GET">
                    <input type="text" name="search" placeholder="Search for campaigns">
                    <button type="submit">Search</button>
                </form>
            </li>
        </ul>
    </nav>
</header>
