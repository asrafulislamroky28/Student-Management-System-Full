<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us - Student Management System</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f9;
      color: #333;
      line-height: 1.6;
      animation: fadeIn 1s ease-in;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    header {
      background-color: #2c3e50;
      color: white;
      text-align: center;
      padding: 30px 0;
      font-size: 2.5rem;
      font-weight: 600;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .back-button {
      display: block;
      margin: 30px auto -30px auto;
      width: fit-content;
      padding: 10px 20px;
      background-color: #1abc9c;
      color: white;
      text-decoration: none;
      font-weight: bold;
      border-radius: 6px;
      transition: background-color 0.3s ease;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .back-button:hover {
      background-color: #16a085;
    }

    .about-container {
      width: 85%;
      margin: 50px auto;
      padding: 40px;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.8s ease-in-out;
    }

    .about-container h2 {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 30px;
      color: #2c3e50;
      text-align: center;
    }

    .team-member {
      display: flex;
      align-items: center;
      margin-bottom: 30px;
      padding: 20px;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .team-member:hover {
      transform: translateY(-10px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .team-member img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      margin-right: 20px;
      object-fit: cover;
      border: 3px solid #1abc9c;
    }

    .team-member .info {
      flex: 1;
    }

    .team-member .info h3 {
      font-size: 1.5rem;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 10px;
    }

    .team-member .info p {
      font-size: 1rem;
      color: #7f8c8d;
      margin-bottom: 5px;
    }

    .team-member .info p span {
      font-weight: bold;
      color: #1abc9c;
    }

    @media (max-width: 768px) {
      .team-member {
        flex-direction: column;
        text-align: center;
        align-items: center;
        padding: 15px;
      }

      .team-member img {
        margin-bottom: 15px;
      }

      .team-member .info {
        text-align: center;
      }

      .back-button {
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<body>

  <header>
    <h1>About Us</h1>
  </header>

  <a href="admin_dashboard.php" class="back-button">← Back to Dashboard</a>

  <div class="about-container">
    <h2>Meet Our Team</h2>

    <!-- Team Member 1 -->
    <div class="team-member">
      <img src="m1.jpg" alt="Asraful Islam">
      <div class="info">
        <h3>Asraful Islam</h3>
        <p>ID: <span>21303043</span></p>
        <p>Contact: <span>asrafulislamroky11@gmail.com</span></p>
        <p>Program: <span>BCSE</span></p>
      </div>
    </div>

    <!-- Team Member 2 -->
    <div class="team-member">
      <img src="m2.jpg" alt="Elma Monsura Mredu">
      <div class="info">
        <h3>Elma Monsura Mredu</h3>
        <p>ID: <span>21303197</span></p>
        <p>Contact: <span>21303197@iubat.edu</span></p>
        <p>Program: <span>BCSE</span></p>
      </div>
    </div>

    <!-- Team Member 3 -->
    <div class="team-member">
      <img src="m3.jpg" alt="Mohammad Asif Bhuiyan">
      <div class="info">
        <h3>Mohammad Asif Bhuiyan</h3>
        <p>ID: <span>21303172</span></p>
        <p>Contact: <span>bynasif2002@gmail.com</span></p>
        <p>Program: <span>BCSE</span></p>
      </div>
    </div>

    <!-- Team Member 4 -->
    <div class="team-member">
      <img src="m4.jpg" alt="Nusrat Shefa">
      <div class="info">
        <h3>Nusrat Shefa</h3>
        <p>ID: <span>22103192</span></p>
        <p>Contact: <span>shafanusrat9@gmail.com</span></p>
        <p>Program: <span>BCSE</span></p>
      </div>
    </div>

    <!-- Team Member 5 -->
    <div class="team-member">
      <img src="m5.jpg" alt="Nusrat Jahan Srabone">
      <div class="info">
        <h3>Nusrat Jahan Srabone</h3>
        <p>ID: <span>21303005</span></p>
        <p>Contact: <span>snusratjahansrabone@gmail.com</span></p>
        <p>Program: <span>BCSE</span></p>
      </div>
    </div>
  </div>

</body>
</html>
