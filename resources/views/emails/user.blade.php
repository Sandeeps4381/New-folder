<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   
</head>
<body>

<table width="100%" border="0" align="center">
                        <tbody>
                            <tr height="80">
                                <td align="center">
                                    {{-- <img src="https://uomtest.vtechsolution.com/uom_mias/public/assets/images/logo.png" alt="logo" style="width: 270px;"> --}}
                                    <img src="{{env('APP_URL')}}/assets/images/logo.png"
                                        alt="University of Missouri logo"
                                        style="width: 270px;">
                                </td>
                            </tr>
                            <tr style="background-color: #f6f6f6;" height="350">
                                <td>
                                <table width="100%" border="0" align="center">
                                        <tbody>
                                            <tr style="background-color: #f6f6f6;" >
                                                <td align="center">
                                                    <table width="100%" border="0" align="center">
                                                        <tbody>
                                                        <tr>
                                                                <td align="center" style="font-weight: 800;">
                                                            Welcome to the 
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" style="font-weight: 800;">
                                                                Motivational Interviewing Training & Assessment System (MITAS)
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td align="left">
                                                                Dear {{$user -> name}}, 
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left">
                                                                Welcome to the University of Missouri's MITAS!
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left">
                                                                We are excited to have you on board. You have been successfully added as a user in our system. Please find your login details below:
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td align="left">
                                                                Username: {{$user -> email}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left">
                                                                    Password: {{$user -> pass}}
                                                                </td>
                                                            </tr>
                                                            <tr align="center" valign="middle" height="80">
                                                                                <td align="center"><a href="http://uomtest.vtechsolution.com/uom_mias/public/"
                                                                                        style=" font-weight: 700; padding: 10px 30px;border-radius: 4px;background-color: #f1b82d;color:#000;text-decoration: none;">Login Now
                                                                                    </a></td>
                                                                            </tr>
                                                            <tr>
                                                                <td align="left">
                                                                To get started, please follow these steps:
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left">
                                                                1. Click on the "Login Now" button above.
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left">
                                                                2. Log in using your User ID and Password.
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td align="left">
                                                                If you encounter any issues or have any questions, please do not hesitate to contact
                                our support team at [Support Email/Contact Information].
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" height="100">
                                                                We look forward to your contributions and hope you have a great experience.
                                                                </td>
                                                            </tr>
                                                    </tbody>        
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                               </td>
                            </tr>
      


                      <tr style="background-color: #fff;"><td>
                            <table width="100%" border="0">
                                <tbody>
                            <tr style="font-size: 16px; font-weight: 500;">
                                <td height="30" align="center">
                                The University of Missouri is a public land-grant research university in Columbia, Missouri. It is Missouri's largest university.
                                </td>
                            </tr>
                           
                            <!-- <tr>
                                <td align="center">
                                   <a href="#" style="color: #000; margin-right: 10px;">Terms of Service</a>
                                    <a href="#" style="color: #000;">Privacy Policy</a> 
                                </td>

                            </tr> -->
                            <tr style="font-size: 16px;font-weight: 700;" align="center">
                                <td height="50" style="color: #444444;">
                                  125 Jesse Hall, University of Missouri Columbia, MO 65211
                                </td>
                            </tr>
                            </tbody>
                            </table>
                            </td></tr>
        </tbody>
    </table>
    
</body>
</html>