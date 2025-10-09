<?php
// Mechanical Dashboard Main Layout
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Mechanical Dashboard'; ?></title>
    <link rel="icon" type="image/png" href="../../images/logo.png">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="mech-wrapper">
        <?php include 'inspectors_header.php'; ?>
        
        <main class="mech-content" id="content">
            <?php echo $content ?? ''; ?>
        </main>
        
        <?php include 'inspectors_nav.php'; ?>
    </div>
    
    <?php if (isset($scripts)): ?>
        <?php echo $scripts; ?>
    <?php endif; ?>
</body>
</html>
