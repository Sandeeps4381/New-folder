<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIAS || UOM</title>

    <style>
      /* Center the table horizontally */
      table {
        margin: 5px auto;
        background-color: #DAE0DA;
        padding: 30px;
        box-align: center;
      }

      .view_logo {
        margin: 5px auto;
        width: auto;
        height: auto;
        text-align: center;
        box-align: center;
      }

      /* Style for the button */
      .accept-button {
          display: inline-block;
          font-weight: 700;
          padding: 10px 30px;
          border-radius: 25px; /* Makes the button rounded */
          background-color: #f1b82d; /* Button background color */
          color: #000; /* Text color */
          text-decoration: none; /* Remove underline from link */
          text-align: center; /* Center text in the button */
          border: none; /* Remove border */
          font-size: 16px; /* Adjust font size if needed */
          cursor: pointer; /* Change cursor to pointer on hover */
      }

      .container {
        margin: 5px auto;
        padding: 40px;
        text-align: center;
        box-align: center;
      }
    </style>
</head>
<body>

  
  
        <div class="view_logo">
          <img src="{{env('APP_URL')}}/assets/images/logo.png" alt="University of Missouri logo">
      </div>
  
  <table width="100%">
    <tbody>
      <tr valign="middle" height="80">
        <td>
          <b>Invitation to Join Our Exciting New Project at the University of Missouri!!</b>
        </td>
      </tr>
      <tr valign="middle" height="80">
        <td>
          Hi Participant,<br>
          You've been invited to complete the <b>{{ $assessmentRecord->title }}</b> by <b>{{ $userRecord->name . ' ' . $userRecord->lname }}.</b><br>
          Click on the <b>"Accept"</b> button to view the assessment.
        </td>
      </tr>

      <tr align="center" valign="middle" height="80">
        <td>
          <a href=" {{ route('invite.inviteusercall',['token'=>$assessmentintives->invite_code]) }}"
            class="accept-button">
            Accept      
          </a>
        </td>
      </tr>

      @if (!empty($userInput))
        <tr>
          <td>
            Message from your assessment supervisor, <b>{{ $userInput }}</b>
          </td>
        </tr>
      </tbody>
    @endif

  </table>
  <div class="footer-bottom-2 mt-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <p>The University of Missouri is a public land-grant research university in Columbia,<br> Missouri. It is Missouri's largest university. 
                      
                      <i class="fa fa-map-marker"></p>
                    <p class="mt-4"><i class="fa fa-map-marker" aria-hidden="true"></i> 125 Jesse Hall , University of Missouri Columbia, MO 65211</p>
                </div>
            </div>
        </div>
    </div>
  </div>
</body>
</html>