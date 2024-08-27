@extends('layout/header')

@section('content')

<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
  }

  .box_ass {
    margin: 20px auto;
    max-width: auto;
    background-color: white;
    border-radius: 8px;
    padding: 40px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  .ass_box {
    margin-left: 30px;
    margin-top: 30px;
    margin-right: 30px;
    max-width: auto;
    background-color: white;
    border-radius: 8px;
    border: 2px solid #f1f1f1; /* Set the border color and thickness */
}


  .container {
    
  margin: 20px auto;
  width: calc(100% - 20px); /* Adjust the width to account for the left and right margins */
  max-width: 100%; /* Ensure it uses the full available width */
  background-color: white;
  border-radius: 8px;
  border: 2px solid #f1f1f1;

  padding: 0; /* Ensure no padding affects the width */
  box-sizing: border-box; /* Include padding and border in element's total width */
}

.section-title {
  background-color: #ffc107;
  width: 100%; /* Ensure it spans the full width of its container */
  padding: 10px;
  text-align: center; /* Center text within the title */
  font-size: 20px;
  border-radius: 8px 8px 0 0;
  margin: 0; /* Remove margin to fit edge-to-edge */
  box-sizing: border-box; /* Include padding in width calculation */
}


  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .back-arrow {
    cursor: pointer;
    font-size: 24px;
    text-decoration: none;
  }

 



  .data-table {
    width: 100%;
    
    margin: 20px 0;
  }

  .data-table th, .data-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  .data-table th {
    font-weight: bold;
    color: grey;
  }

  .data-table td {
    font-weight: bold;
    color: black
  }

  .score-table {
    width: 100%;
    margin: 20px 0;
  }

  .score-table th, .score-table td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  .score-table th {
    font-weight: bold;
    color: #333;
  }

  .score-table td {
    color: #555;
  }

  .submit-btn-container {
  display: flex;
  justify-content: center; /* Center the button horizontally */
  margin: 20px 0; /* Add margin if needed */
}

.submit-btn {
  background-color: #ffc107;
  padding: 10px 20px;
  border-radius: 5px;
  border: none;
  font-size: 16px;
  color: white;
  cursor: pointer;
  text-align: center;
  display: block;
  align-items: center;
  /* Remove width: 100% to avoid stretching the button */
}


  .footer {
   
    display: flex;
    justify-content: center; /* Center the logo horizontally */
    align-items: center;
    margin-top: 50px;
    background-color:#f2efef;
    padding: 10px; /* Add padding to the footer */
    border-radius: 0 0 8px 8px; /* Rounded corners at the bottom */
  }

  .footer img {
    width: 150px;
  }
</style>

<div class="header">
<div class="bd-text">
        <h3><a href="javascript:void(0)" class="backlink"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
            <b>Assessment Result</b></h3>
    </div>
    <button id="exportBtn" style="padding: 8px 12px; border-radius: 5px; cursor: pointer; color: black; border: 2px solid black; background-color: transparent; display: flex; align-items: center;">
    Export <i class="fas fa-download" style="color: black; margin-left: 8px;"></i>
  </button>



</div>

<div class="box_ass">
  <div class="container">
    <!-- Section Title -->
    <h3 class="section-title">AI Technology Features</h3>

    <!-- Data Table -->
    <div class="ass_box">
      <table class="data-table">
        <tr>
          <th> Name</th>
          <td>Alexa Jhon</td>
        </tr>
        <tr>
          <th>Project Manager</th>
          <td>Steve Loren</td>
        </tr>
        <tr>
          <th>Scorer/Reviewer</th>
          <td>Daniel Smith</td>
        </tr>
        <tr>
          <th>Assessment Level</th>
          <td>Baseline</td>
        </tr>
        <tr>
          <th>Knowledge Score (% correct)</th>
          <td>80%</td>
        </tr>
        <tr>
          <th>Total Questions</th>
          <td>24/30</td>
        </tr>
   

  
      <table style="border-collapse: collapse; width: 100%;">
      <tr>
  <th style="padding: 12px; font-weight: bold; text-align: left; color: grey; border-bottom: 1px solid #ddd;">
    Total Range
  </th>
  <td style="padding-right: 38px; font-weight: bold; border-bottom: 1px solid #ddd;">
    35 (75% : >= 36)
  </td>
</tr>

  <tr>
    <th style="padding: 12px;font-weight: bold; text-align: left; border-bottom: none; color: grey;">O = Open-ended questions (Range: 0 - 12)</th>
    <td style="padding-right:38px; font-weight: bold; border-bottom: none;">9 (75% : >= 9)</td>

  </tr>
  <tr>
    <th style="padding: 12px;font-weight: bold; text-align: left; border-bottom: none; color: grey;">A = Affirmations (Range: 0 - 6)</th>
    <td style="padding-right:38px;font-weight: bold; border-bottom: none;">4 (75% : >= 4)</td>
  </tr>
  <tr>
    <th style="padding: 12px;font-weight: bold; text-align: left; border-bottom: none; color: grey;">R = Reflective Listening (Range: 0 - 24)</th>
    <td style="padding-right:38px;font-weight: bold; border-bottom: none;">18 (75% : >= 18)</td>
  </tr>
  <tr>
    <th style="padding: 12px;font-weight: bold; text-align: left; border-bottom: none; color: grey;">S = Summaries (Range: 0 - 6)</th>
    <td style="padding-right: 38px;font-weight: bold; border-bottom: none;">4 (75% : >= 4)</td>
  </tr>
</table>

      </table>
    </div>

    <!-- Submit Button -->
    <div class="submit-btn-container">
  <button class="submit-btn">Submit</button>
</div>

    <!-- Footer -->
    <div class="footer">
    <img src="\assets\images\logo-1.png" alt="" width="20%" height="20%">
    </div>
  </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script>
  // Back button logic
  document.getElementById("exportBtn").addEventListener("click", function() {
    html2canvas(document.querySelector(".container"), {
      onrendered: function(canvas) {
        var link = document.createElement('a');
        link.href = canvas.toDataURL("image/png");
        link.download = "assessment_result.png";
        link.click();
      }
    });
  });

</script>

@endsection
