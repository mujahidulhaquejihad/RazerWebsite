<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$sent = isset($_GET['sent']) && $_GET['sent'] === '1';
$error = isset($_GET['error']) && $_GET['error'] === '1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | PC Builder</title>
    <link rel="stylesheet" href="styles/contact_us.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="contact-page">
        <h1 class="contact-page-title">Contact Us</h1>
        <p class="contact-page-intro">Get in touch for custom builds, bulk orders, or support.</p>

        <?php if ($sent): ?>
        <p class="contact-flash contact-flash-success">Message sent. We'll get back to you soon.</p>
        <?php endif; ?>
        <?php if ($error): ?>
        <p class="contact-flash contact-flash-error">Please fill in all fields and try again.</p>
        <?php endif; ?>

        <div class="contact-flex">
            <div class="contact-info">
                <h2>Visit or reach out</h2>
                <p><strong>Address</strong><br>Level 4, Tech Hub Tower, Gulshan Avenue North, Dhaka 1212, Bangladesh</p>
                <p><strong>Email</strong><br><a href="mailto:support@pcbuilder-bd.com">support@pcbuilder-bd.com</a></p>
                <p><strong>Phone</strong><br>+880 1XXX-XXXXXX (10:00 AM – 8:00 PM, Sat–Thu)</p>
                <p><strong>Office hours</strong><br>10:00 AM – 8:00 PM, Saturday – Thursday. Closed on Friday.</p>
            </div>
            <div class="contact-form-wrap">
                <h2>Send a message</h2>
                <form class="contact-form" action="contact_submit.php" method="post">
                    <label for="contact_name">Name</label>
                    <input type="text" id="contact_name" name="name" placeholder="Your name" required>
                    <label for="contact_phone">Phone</label>
                    <input type="text" id="contact_phone" name="phone" placeholder="Phone number" required>
                    <label for="contact_email">Email</label>
                    <input type="email" id="contact_email" name="email" placeholder="your@email.com" required>
                    <label for="contact_message">Message</label>
                    <textarea id="contact_message" name="message" rows="4" placeholder="Ask about builds, compatibility, or bulk orders..." required></textarea>
                    <button type="submit">Send message</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
