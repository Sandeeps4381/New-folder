<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<table width="100%" border="0" align="center">
        <tbody>
            <tr>
                <td align="center">
                    <table width="100%" border="0" align="center">
                        <tbody>
                            <tr height="80">
                                <td align="center">
                                    
                                        <img src="{{env('APP_URL')}}/assets/images/logo.png"
                                        alt="University of Missouri logo"
                                        style="width: 270px;">
                                    {{-- <img src="https://uomuat.vtechsolution.com/assets/images/logo.png" alt="logo" style="width: 270px;"> --}}
                                </td>
                            </tr>
                            <tr style="background-color: #f6f6f6;" height="350">
                                <td>
                                    <table width="100%" border="0">
                                        <tbody>
                                            <tr style="font-size: 16px; font-weight: 500;">
                                                <td align="left" height="60">Hi {{$user -> name}}, Password Reset Request for {{$user -> email}}
                                                    We received a request to reset the password associated with your
                                                    account. If you made this request, please click the button below to
                                                    reset your
                                                    password:</td>
                                            </tr>

                                            <tr align="center" valign="middle" height="80">
                                                <td align="center"><a href="{{url('resetpassword/'. $user -> remember_token) }}"
                                                        style=" font-weight: 700; padding: 10px 30px;border-radius: 4px;background-color: #f1b82d;color:#000;text-decoration: none;">Reset
                                                        Password
                                                    </a></td>
                                            </tr>

                                            <tr style="font-size: 16px; font-weight: 500;">
                                                <td align="left" height="60">
                                                    If the button above doesn't work, copy and paste the following link
                                                    into your
                                                    browser This link will expire in 24 hours. If you did not request a
                                                    password reset,
                                                    please ignore this email or contact our support team if you have any
                                                    concerns.
                                                    For security reasons, we will never ask for your password or any
                                                    personal
                                                    information via email.
                                                    
                                                </td>
                                            </tr>

                                            <tr style="font-size: 16px; font-weight: 500;">
                                                <td align="left" height="60">

                                                    Thank you!
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                            <table width="100%" border="0">
                                <tbody>
                            <tr style="font-size: 16px; font-weight: 500;">
                                <td height="30" align="center">
                                    The University of Missouri is a public land-grant research university in Columbia,
                                    Missouri. It is Missouri's largest university.
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
                </td>
            </tr>

        </tbody>
    </table>
    
</body>
</html>