<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // 1. Collect and sanitize form fields
    $firstName   = strip_tags(trim($_POST["firstName"] ?? ''));
    $lastName    = strip_tags(trim($_POST["lastName"] ?? ''));
    $company     = strip_tags(trim($_POST["company"] ?? ''));
    $workEmail   = filter_var(trim($_POST["workEmail"] ?? ''), FILTER_VALIDATE_EMAIL);
    $workRole    = strip_tags(trim($_POST["workRole"] ?? ''));
    $companyType = strip_tags(trim($_POST["companyType"] ?? ''));
    $numBillers  = strip_tags(trim($_POST["numBillers"] ?? ''));

    if (!$workEmail) {
        echo "<script>alert('Invalid email address provided.'); window.history.back();</script>";
        exit;
    }

    // 2. Setup destination details
    $recipient = "soumyad@rssoftware.co.in";
    $subject   = "RS Bill@Edge™ 60-Day Pilot Request - " . $company;
    
    // 3. Create the text message structure
    $email_content = "Hello RS Software Team,\n\n";
    $email_content .= "A new request for the RS Bill@Edge™ 60-Day Pilot has been submitted:\n\n";
    $email_content .= "--------------------------------------------------\n";
    $email_content .= "CONTACT DETAILS\n";
    $email_content .= "--------------------------------------------------\n";
    $email_content .= "Name: $firstName $lastName\n";
    $email_content .= "Role: $workRole\n";
    $email_content .= "Email: $workEmail\n\n";
    $email_content .= "--------------------------------------------------\n";
    $email_content .= "INSTITUTION PROFILE\n";
    $email_content .= "--------------------------------------------------\n";
    $email_content .= "Company: $company\n";
    $email_content .= "Company Type: $companyType\n";
    $email_content .= "Approx. Billers: $numBillers\n\n";
    $email_content .= "--------------------------------------------------\n";
    $email_content .= "Please follow up within one business day to initiate scoping.";

    // 4. Construct email delivery headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/plain; charset=UTF-8" . "\r\n";
    $headers .= "From: RS Lead System <noreply@rssoftware.com>" . "\r\n";
    $headers .= "Reply-To: $workEmail" . "\r\n";

    // 5. Send and redirect back seamlessly
    if (mail($recipient, $subject, $email_content, $headers)) {
        // Redirects back to your previous page and alerts success
        echo "<script>
                alert('Thank you! Your request has been sent successfully.');
                window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
              </script>";
    } else {
        echo "<script>
                alert('The server failed to route the email. Please check your SMTP mail settings.');
                window.history.back();
              </script>";
    }
} else {
    echo "Direct access denied.";
}
?>