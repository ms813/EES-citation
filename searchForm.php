<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script>
        fucntion validateForm() {
            alert('do some validation here');
        }
    </script>
    <?php include( 'header.php'); include( 'navigator.php'); ?>
</head>
<body>
    <div class='main-content'>
        <h2>Search for article alerts</h2>
        <form name='searchForm' action='search.php'
        method='post'>
            <div class='textField'>
                <label class='label' for='searchInput'>Search:</label>
                <input name='searchInput' type='text' placeholder='Enter search URL here'>
            </div>
            <div class='submitDiv'>
                <input type='submit' value='Search'>
            </div>
        </form>
    </div>
</body>
