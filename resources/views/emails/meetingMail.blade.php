<!DOCTYPE html>
<html>

<head>
    <title>Randy</title>
</head>

<body>
    <div class="container-fluid" style="background-color: #E4B513;">
        <div style="display: flex; justify-content: center;padding-top: 55px;">
            <div style="background-color: #e3e3e3;text-align: center;padding: 20px 0 20px 0;width:80%;margin: 0 auto;">
                <img src="https://randystrattonofficiant.ca/assets/src/images/logoemail.jpeg" style="background:transparent;">
            </div>
        </div>
    </div>
    <div style="display: flex; justify-content: center;">
        <div style="background-color: #e3e3e3;text-align: center;padding: 20px 0 20px 0;width:80%;margin: 0 auto;">
            <h5 style="color: #E4B513;font-size: 26px;font-weight: 700;padding: 0;margin: 0;">Congratulations</h5>
            <p>You have a new inquiry from your website</p>
        </div>
    </div>
    <div style="display: flex; justify-content: center;">
        <table width="100%" border="1" cellpadding="10px" cellspacing="0" style="text-align: left;width: 80%;border: 1px solid #f1f1f1;margin: 0 auto;">
            <tr>
                <td><label style="font-size: 15px;font-weight: 700;color: #000;margin:0 !important;">Groom Name: </label> {{ isset($user_data['groom_name']) ? $user_data['groom_name'] : '-' }}</td>
                <td><label style="font-size: 15px;font-weight: 700;color: #000;margin:0 !important;">Bride Name: </label> {{ isset($user_data['bride_name']) ? $user_data['bride_name'] : '-' }}</td>
            </tr>
            <tr>
                <td colspan="2"><label style="font-size: 15px;font-weight: 700;color: #000;margin:0 !important;">Email: </label> {{ isset($user_data['email']) ? $user_data['email'] : '-' }}</td>
            </tr>
            <tr>
                <td><label style="font-size: 15px;font-weight: 700;color: #000;margin:0 !important;">Date: </label> {{ isset($user_data['date'] ) ? $user_data['date'] : '-' }}</td>
                <td><label style="font-size: 15px;font-weight: 700;color: #000;margin:0 !important;">Time: </label> {{ isset($user_data['time']) ? $user_data['time'] : '-' }}</td>
            </tr>
            <tr>
                <td><label style="font-size: 15px;font-weight: 700;color: #000;margin:0 !important;">Phone Number: </label> {{ isset($user_data['phone_number']) ? $user_data['phone_number'] : '-' }}</td>
                <td><label style="font-size: 15px;font-weight: 700;color: #000;margin:0 !important;">Ceremony Type: </label> {{ isset($user_data['ceremony_type']) ? $user_data['ceremony_type'] : '-' }}</td>
            </tr>
            <tr>
                <td colspan="2"><label style="font-size: 15px;font-weight: 700;color: #000;margin:0 !important;">Ceremony Venue: </label> {{ isset($user_data['ceremony_value']) ? $user_data['ceremony_value'] : '-' }}</td>
            </tr>
            <tr>
                <td colspan="2"><label style="font-size: 15px;font-weight: 700;color: #000;margin:0 !important;">Additional Info: </label> {{ isset($user_data['additional_info']) ? $user_data['additional_info'] : '-' }}</td>
            </tr>
        </table>
    </div>
    
    
 
    
</body>

</html>
