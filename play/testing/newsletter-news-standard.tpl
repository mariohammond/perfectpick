<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    {section name=region loop=$regions.header}
        {region widget=$regions.header[region]}
    {/section}
    <title>{$emailList}</title>
    <meta name="viewport" content="width=device-width,user-scalable=0">
</head>
{if !$emailList}{assign var="emailList" value="Weekly Standard Newsletter"}{/if}
<body style="font-size: 18px; color: #000000; font-family: Arial, Helvetica, sans-serif; margin:0; padding:0;">
    <table class="toplevel" width="{$tableWidth}" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td align="center" style="padding: 10px 0px 10px 0px;"><p style="color: #000000; font-family: {$fontFamily}; font-size: 12px; margin: 0px; padding: 0px; line-height: 16px;">View this email as a <a href="%%view_email_url%%"
alias="Vawp" style="color: #0000ff;">webpage</a></p></td>
        </tr>
        <tr>
        	<td style="text-align:center; padding: 0px;"><a href="http://www.weeklystandard.com/{$analyticsString}"><img class="logo" src="{$logo}" alt="Washington Examiner" width="{$logoWidth}" border="0" style="display: block; margin: 0px auto;"></a></td>
        </tr>
        <tr>
        	<td style="padding:5px 10px; text-align:center"><a href="http://www.weeklystandard.com/{$analyticsString}" style="text-decoration:none; color:#000;"><h2 class="headerText" style="margin:0; font-size:{$headerFontSize}; line-height:{$headerLineHeight}; font-family: {$fontFamily};">News from WashingtonExaminer.com</h2></a></td>
        </tr>
        <tr>
        	<td><hr style="border: 0; border-bottom: 3px solid {$borderColor}; background: #FFFFFF; margin-top: 0px; margin-bottom:20px;"></td>
       	</tr>
        <tr>
        	<td valign="top" style="mso-table-lspace: 0; mso-table-rspace: 0;">
                {section name=region loop=$regions.region_2}
                    {region widget=$regions.region_2[region] region_name='2'}
                {/section}
            </td>
        </tr>
        <tr id="nav" style="width:80%;">
            <td style="width:20%; text-align:center; background-color:#ed1b34;"><a style="display:block; color:#FFFFFF; font-size:12px; font-weight:bold; text-decoration:none; padding: 10px;" href="http://www.weeklystandard.com/today">TODAY</a></td>
            <td style="width:20%; text-align:center; background-color:#ed1b34;"><a style="display:block; color:#FFFFFF; font-size:12px;font-weight:bold; text-decoration:none; padding: 10px;" href="http://www.weeklystandard.com/issue">MAGAZINE</a></td>
            <td style="width:20%; text-align:center; background-color:#ed1b34;"><a style="display:block; color:#FFFFFF; font-size:12px;font-weight:bold; text-decoration:none; padding: 10px;" href="http://events.weeklystandard.com/">EVENTS</a></td>
            <td style="width:20%; text-align:center; background-color:#ed1b34;"><a style="display:block; color:#FFFFFF; font-size:12px;font-weight:bold; text-decoration:none; padding: 10px;" href="http://www.weeklystandard.com/contact">CONTACT US</a></td>
            <td style="width:20%; text-align:center; background-color:#ed1b34;"><a style="display:block; color:#FFFFFF; font-size:12px;font-weight:bold; text-decoration:none; padding: 10px;" href="https://subservices.weeklystandard.com/ITPS2.cgi?ordertype=reply+only&itemcode=wstd&iresponse=wstd.tws_site_landing&KeyCode=E24&uKey=E48&utm_source=home&utm_medium=navlink&utm_campaign=sub_bottomnav">SUBSCRIBE NOW</a></td>
        </tr>
        <tr>
        	<td colspan="5" style="text-align:center; margin-top:20px;"><a href="http://weeklystandard.com"><img src="{$logo}" alt="Weekly Standard" width="102" height="45" vspace="4" border="0" align="center"></a></td>
        </tr>
        <tr>
          <td colspan="5" width="80" align="center">
                <a href="https://www.facebook.com/weeklystandard/" target="_blank" style="text-decoration:none;">
          <img src="http://s3.amazonaws.com/content.washingtonexaminer.biz/wex15/img/social-facebook.png" style="width:30px; margin-right:5px; margin-top:10px; text-align:center;" />
          </a>
          <a href="https://twitter.com/weeklystandard" target="_blank" style="text-decoration:none;">
          <img src="http://s3.amazonaws.com/content.washingtonexaminer.biz/wex15/img/social-twitter.png" style="width:30px; margin-top:10px; text-align:center;" />
          </a>
          <div class="clear" style="margin-top:10px; clear:both;"></div>
          </td>
        </tr>
        <tr>
        	<td style="padding: 20px 0px 0px 0px;"><hr style="border: 0; border-bottom: 3px solid {$borderColor}; background: #FFFFFF; margin-top: 0px; margin-bottom:10px;"></td>
       	</tr>
        <tr>
            <td align="center" style="padding: 0px 0px 10px 0px;">
                <p style="color: #777777; font-family: {$fontFamily}; font-size: 10px; margin: 0px; padding: 0px; line-height: 14px;">This email was sent by: %%Member_Busname%%<br>
                %%Member_Addr%% %%Member_City%%, %%Member_State%% %%Member_PostalCode%% %%Member_Country%%</p>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 0px 0px 10px 0px;">
                <p style="color: #777777; font-family: {$fontFamily}; font-size: 10px; margin: 0px; padding: 0px; line-height: 14px;">We respect your right to privacy - <a href="http://www.weeklystandard.com//privacy-policy" alias="View Privacy Policy" style="color: #0000ff;">View our policy</a></p>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 0px 0px 10px 0px;">
                <p style="color: #777777; font-family: {$fontFamily}; font-size: 10px; margin: 0px; padding: 0px; line-height: 14px;"><a href="%%unsub_center_url%%" alias="Unsubscribe">One-Click Unsubscribe</a></p>
            </td>
        </tr>
    </table>
    <custom name="opencounter" type="tracking">
</body>
</html>