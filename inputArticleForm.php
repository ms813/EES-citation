<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script>
        function validateForm() {
            //alert('do some validation here');
        }
    </script>
    <?php include('header.php'); ?>
        <?php include('navigator.php'); ?>
</head>
<body>
    <div class='main-content'>
        <h2>Input article</h2>
        <form name='input' action='addArticle.php' method='post' onsubmit='return validateForm()'>
            <div class='textField'>
                <label for='title' class='fieldLabel'>Title:</label>
                <input type='text' name='title' placeholder='An analysis of pop music from 1980–present'>
            </div>
            <br/>
            <div class='textField'>
                <label for='authors' class='fieldLabel'>Authors:</label>
                    <input type='text' name='authors' placeholder='M. Jackson, F. Mercury and J. Bieber'>
                    <label for='authors' class='comment'>(separated by a comma)</label>
                </div>
            <br/>
            <div class='combobox'>
                <label for='journal' class='fieldLabel'>Journal:</label>
                <select name='journal'>
                    <option value='Energy & Environmental Science'>Energy & Environmental Science</option>
                    <option value='Nanoscale'>Nanoscale</option>
                    <option value='Physical Chemistry Chemical Physics'>Physical Chemistry Chemical Physics</option>
                </select>
            </div>
            <br/>
            <div class='textField'>
                <label for='year' class='fieldLabel'>Year:</label>
                <input type='text' name='year' value='2013'>
            </div>
            <br/>
            <div class='textField'>
                <label for='volume' class='fieldLabel'>Volume:</label>
                <input type='text' name='volume' placeholder='666'>
            </div>
            <br/>
            <div class='textField'>
                <label for='pages'  class='fieldLabel'>Pages:</label>
                <input type='text' name='pages' placeholder='1234-5678'>
                <label for='pages' class='comment'>(separated by a hyphen)</label>
            </div>
            <br/>
            <div class='textField'>
                <label for='keyWords'  class='fieldLabel'>Key words:</label>
                <input type='text' name='keyWords' placeholder='Photovoltaic, solar cell etc...'>
            </div>
            <div class='submitDiv'>
                <input type='submit' value='Submit'>
            </div>
        </form>
    </div>
</body>
