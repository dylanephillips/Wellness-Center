<!DOCTYPE html>
<html>

    <!-- the head section using css-->
    <head>
        <title>Wellness Center Error</title>
        <link rel="stylesheet" type="text/css" href="../../public/css/main.css"/>
    </head>

    <!-- the body section: contains error message if cannot connect to database-->
    <body>
        <header><h1>Wellness Center</h1></header>

        <main>
            <h1>Database Error</h1>
            <p>There was an error connecting to the database.</p>
            <p>Error message: <?php echo $error_message; ?></p>
            <p>&nbsp;</p>
        </main>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Wellness Center</p>
        </footer>
    </body>
</html>
