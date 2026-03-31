<?php // Database connection for displaying data 
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "taste_tribe"; 
$conn = new mysqli($servername, $username, $password, $dbname); 
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title>HomePage</title>     
    <link rel="stylesheet" href="styles.css">     
    <link rel="preconnect" href="https://fonts.googleapis.com">     
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>     
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">     
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Satisfy&display=swap" rel="stylesheet">     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"> 
</head> 

<body> 
<header>     
    <div class="header-top">         
        <h1 class="logo">Taste Tribe <i class="fa-solid fa-seedling"></i></h1>         
        <div class="Profile">             
            <a href="Profile.html" class="profile-link" title="Profile">                 
                <i class="fa-regular fa-user"></i>             
            </a>         
        </div>     
    </div>     

    <nav id="nav-bar" class="collapsed">     
    <ul>         
        <li class="menu-btn">             
            <span class="menu">Menu</span>             
            <button onclick=toggleSidebar() id="toggle-btn">                 
                <i class="fa-solid fa-bars"></i>             
            </button>         
        </li>         

        <li class="dropdown">             
            <a href="index.html" class="dropdown-toggle" title="Home">                 
                <i class="fa-regular fa-house"></i>                 
                <span>Home</span>                 
                <i class="fa-solid fa-angle-down dropdown-icon"></i>             
            </a>             
            <ul class="sub-menu">                 
                <li><a href="index.html#about-us">About Us</a></li>                 
                <li><a href="index.html#trending-discussions">Trending Discussions</a></li>                 
                <li><a href="index.html#featured-guides">Featured Guides</a></li>                 
                <li><a href="index.html#comm-highlights">Community Highlights</a></li>             
            </ul>         
        </li>         

        <li>             
            <a href="Forum.html" title="Forum">                 
                <i class="fa-regular fa-comments"></i>                 
                <span>Forum</span>             
            </a>         
        </li>         

        <li class="dropdown">             
            <a href="Resources.php" class="dropdown-toggle" title="Resources">                 
                <i class="fa-solid fa-gears"></i>                 
                <span>Resources</span>                 
                <i class="fa-solid fa-angle-down dropdown-icon"></i>             
            </a>              
            <ul class="sub-menu">                 
                <li><a href="Resources.php#food-exploration-guide">Food Exploration Guide</a></li>                 
                <li><a href="Resources.php#food-tips">Food Tips</a></li>                 
                <li><a href="Resources.php#cafe-hunting">Cafe Hunting</a></li>             
            </ul>         
        </li>         

        <li class="logout-btn">             
            <a href="Login.html" title="LogIn/LogOut">                 
                <i class="fa-solid fa-arrow-right-from-bracket"></i>                 
                <span>Log Out</span>             
            </a>         
        </li>     
    </ul>     
    </nav>     
</header>  

<div class="HomePage">   
<main>          

<section>         
<h1>Resources</h1>         
<p>The Resources section provides guides, tips, and curated content to help food enthusiasts explore and enjoy food culture more effectively.</p>         

<?php         
if (isset($_GET['success']) && $_GET['success'] == 'created') {             
    echo "<p style='color: green; font-weight: bold;'>Resource shared successfully!</p>";             
    echo "<script>history.replaceState({}, '', window.location.pathname);</script>";         
}          

if (isset($_GET['success']) && $_GET['success'] == 'deleted') {             
    echo "<p style='color: orange; font-weight: bold;'>Resource deleted.</p>";             
    echo "<script>history.replaceState({}, '', window.location.pathname);</script>";         
}         
?>     
</section>     

<section id="submit-resource">     
<h2>Submit a New Resource</h2>     

<form action="process_resource.php" method="POST" class="resource-form">         
<input type="text" name="title" placeholder="Resource Title (e.g., Best Satay in Penang)" required>                  

<select name="category" required>             
<option value="FoodHunt">Food Exploration</option>             
<option value="SpotRestaurant">Food Tips</option>             
<option value="cafe-hunting">Cafe Hunting</option>         
</select>                  

<textarea name="content" placeholder="Share your tips or guide here..." required></textarea>                  

<button type="submit" name="submit_resource">Post Resource</button>     
</form> 
</section>  

<section id="community-shared">     
<h2>Community Shared Insights</h2>     

<!-- ADDED FILTER HERE -->
<section id="filter-section">
<form method="GET">
<label><strong>Filter by Category:</strong></label>
<select name="category_filter" id="category_filter" onchange="this.form.submit()">
<option value="">All</option>

<option value="Food Exploration"
<?php if(isset($_GET['category_filter']) && $_GET['category_filter']=="Food Exploration") echo "selected"; ?>>
Food Exploration
</option>

<option value="Food Tips"
<?php if(isset($_GET['category_filter']) && $_GET['category_filter']=="Food Tips") echo "selected"; ?>>
Food Tips
</option>

<option value="Cafe Hunting"
<?php if(isset($_GET['category_filter']) && $_GET['category_filter']=="Cafe Hunting") echo "selected"; ?>>
Cafe Hunting
</option>

</select>
</form>
</section>    

<div class="shared-container">     
<?php
//ADDED FILTER LOGIC
$filter = "";
if (isset($_GET['category_filter']) && $_GET['category_filter'] != "") {
    $category = $conn->real_escape_string($_GET['category_filter']);
    $filter = "WHERE category = '$category'";
}

//MODIFIED QUERY ONLY
$sql = "SELECT * FROM resources $filter ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {             
    while($row = $result->fetch_assoc()) {                 
        echo "<div class='resource-item'>";                 
        echo "<h3>" . htmlspecialchars($row['title']) ."</h3>";   

        // ADDED CATEGORY DISPLAY
        echo "<p>
        <strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>";

        echo "<article>" . nl2br(htmlspecialchars($row['content'])) . "</article>";                 

        echo "<a href='process_resource.php?delete=" . $row['id'] . "' class='delete_resource'  
        onclick='return confirm(\"Are you sure you want to delete this?\")'>
        <i class='fa-solid fa-trash'></i>Delete</a>";                 

        echo "</div>";             
    }         
} else {             
    echo "<p>No community resources shared yet. Be the first to post!</p>";         
}         

$conn->close();         
?>     

</div> 
</section>

<section id="food-exploration-guide">
  <h2>Food Exploration Guides</h2>
  <div id="FoodHunt">
  <h3>Beginner’s Guide to Food Hunting</h3>
  <p>Food hunting is a popular activity among food lovers. To start exploring new food places, consider the following tips:</p>
  <ul>
    <li><i class="fa-solid fa-book-open"></i>Research popular dishes in your area.</li>
    <li><i class="fa-regular fa-comment-dots"></i>Ask locals for recommendations.</li>
    <li><i class="fa-solid fa-store"></i>Try small food stalls instead of only large restaurants.</li>
    <li><i class="fa-solid fa-utensils"></i>Be open to trying unfamiliar foods.</li>
  </ul>
  <p>Exploring food is not only about taste but also about experiencing culture.</p>
  </div>

  <div id="TopFoods">
  <h3>Popular Malaysian Dishes</h3>
  <p>Malaysia has a rich and diverse food culture influenced by Malay, Chinese, and Indian cuisines. Some must-try dishes include:</p>
  <ul>
    <li>
    <figure>
        <img src="https://foreignfork.com/wp-content/uploads/2025/10/Nasi-Lemak-Feature-Image.jpg" alt="Nasi Lemak">
        <br>
        <figcaption>
            <strong>Nasi Lemak</strong> – fragrant rice served with sambal, egg, peanuts, and anchovies.
        </figcaption>
    </figure>
    </li>

    <li>
    <figure>
        <img src="https://www.wokandskillet.com/wp-content/uploads/2016/07/Char-Kway-Teow.jpg" alt="Char Kway Teow">
        <br>
        <figcaption>
        <strong>Char Kway Teow</strong> – stir-fried noodles with shrimp, egg, and bean sprouts.
        </figcaption>
    </figure>
    </li>

    <li>
    <figure>
        <img src="https://www.rotinrice.com/wp-content/uploads/2011/04/RotiCanai-1.jpg" alt="Roti Canai">
        <br>
        <figcaption>
        <strong>Roti Canai</strong> – crispy flatbread served with curry.
        </figcaption>
    </figure>
    </li>

    <li>
    <figure>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiCPU_3onDTF4O7mth4UMdDfYPB1Ztm1I7LQ&s" alt="Laksa">
        <br>
        <figcaption>
        <strong>Laksa</strong> – spicy noodle soup with rich broth.
        </figcaption>
    </figure>
    </li>

  </ul>
  </div>

  <div id="SpotRestaurant">
  <h3>How to Spot a Great Restaurant</h3>
  <p>Tips to identify a good restaurant:</p>
  <ul>
    <li><i class="fa-regular fa-star"></i>Check the quality and freshness of ingredients.</li>
    <li><i class="fa-regular fa-thumbs-up"></i>Look for good service and a welcoming environment.</li>
    <li><i class="fa-solid fa-binoculars"></i>Observe how busy the restaurant is — often a sign of popularity.</li>
    <li><i class="fa-solid fa-award"></i>Consider the authenticity of the cuisine.</li>
  </ul>
  </div>
</section>

<section class="food-tips" id="food-tips">
  <h2>Budget Food Tips for Students</h2>
  <div>
  <p>Many students want to enjoy good food without spending too much money. Helpful tips:</p>
  <ul>
    <li><i class="fa-solid fa-tag"></i>Look for student meal promotions.</li>
    <li><i class="fa-solid fa-shop"></i>Visit food courts or hawker centers.</li>
    <li><i class="fa-solid fa-user-group"></i>Share meals with friends.</li>
    <li><i class="fa-solid fa-magnifying-glass-location"></i>Explore street food markets.</li>
  </ul>
  <p>Budget-friendly food options can still offer excellent taste and quality.</p>
  </div>
</section>

<section id="cafe-hunting">
  <h2>Café Hunting Guide</h2>
  <div>
  <p>Café culture has become increasingly popular. When choosing a café, consider:</p>
  <ul>
    <li>Comfortable seating and good lighting for studying.</li>
    <li>Affordable drinks and food options.</li>
    <li>Cozy and friendly atmosphere.</li>
    <li>Unique desserts or specialty coffee.</li>
  </ul>
  <p>Some cafés also offer opportunities to take food photos for social media or blogs.</p>
  </div>
</section>

  </main>
</div>
<footer>
    <p>© 2026 Taste Tribe | All Rights Reserved</p>
</footer>
<script src="script.js"></script>
</body>
</html>