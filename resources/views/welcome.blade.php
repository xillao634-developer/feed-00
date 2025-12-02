<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Feedback Portal</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <div class="container">
    <h1>Feedback Portal</h1>
    <p>We value your feedback! Please fill out the form below.</p>
    <form class="feedback-form" id="feedbackForm">
      <div class="input-group">
        <label for="name">Selina Donkor</label>
        <input type="text" id="name" name="name" placeholder="Enter your name" required>
      </div>

      <div class="input-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>

      <div class="input-group">
        <label for="rating">Rating</label>
        <select id="rating" name="rating" required>
          <option value="">Select</option>
          <option value="5">⭐⭐⭐⭐⭐ - Excellent</option>
          <option value="4">⭐⭐⭐⭐ - Very Good</option>
          <option value="3">⭐⭐⭐ - Good</option>
          <option value="2">⭐⭐ - Fair</option>
          <option value="1">⭐ - Poor</option>
        </select>
      </div>

      <div class="input-group">
        <label for="message">Your Feedback</label>
        <textarea id="message" name="message" placeholder="Write your feedback here..." rows="5" required></textarea>
      </div>

      <button type="submit" class="submit-btn">Submit Feedback</button>
    </form>

    <div class="thank-you" id="thankYouMessage">
      <h2>Thank you for your feedback!</h2>
      <p>We appreciate your time and effort in helping us improve.</p>
    </div>
  </div>

  <script>
    const form = document.getElementById('feedbackForm');
    const thankYou = document.getElementById('thankYouMessage');

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      form.style.display = 'none';
      thankYou.style.display = 'block';
    });
  </script>
</body>

</html>