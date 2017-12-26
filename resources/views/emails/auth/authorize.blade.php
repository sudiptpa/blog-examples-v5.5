<!DOCTYPE html>
<html lang="en">
    <head>
      <title>Authorize</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <style>
          body {
            background: #fff;
            background-image: none;
            font-size: 12px;
            font-family: sans-serif;
          }
          h2 {
            font-size:22px;
            line-height:40px;
            color:#5a5a5a;

          }
          .align-center{
            text-align: center;
          }
          .table th {
            vertical-align: bottom;
            font-weight: bold;
            padding: 8px;
            line-height: 20px;
            text-align: left;
          }
          .table td {
            padding: 8px;
            line-height: 20px;
            text-align: left;
            vertical-align: top;
            border-top: 1px solid #dddddd;
          }
          .font-style{
            font-size:14px;
            line-height:22px;
            color:#5a5a5a;
          }
          .btn-authorize{
            padding:15px 25px;
            background-color:#ea413a;
            color:#ffffff;
            border-radius:3px;
            text-decoration:none;
            margin-top:20px;
          }
      </style>
    </head>
    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center">
                    <table align="center" width="798" border="0" cellspacing="0" cellpadding="0">
                        <tr><td height="20"></td></tr>
                        <tr>
                            <td align="left">
                              <div>
                                <h2>Authorize New Device</h2>
                                <hr>
                                <p class="font-style">
                                  A device or location we haven't seen before, or for some time, is requesting access to your account:
                                </p>

                                <p class="font-style">
                                  <strong>IP Address: </strong> {{ $authorize->ip_address }} <br>
                                  <strong>Browser: </strong> {{ $authorize->browser }} ({{ $authorize->os }})<br>
                                  <strong>Location: </strong> {{ $authorize->location }}
                                </p>
                                <p class="font-style">
                                  If you approve of this action, please click the link below to authorize this device.
                                </p>

                                <div style="padding: 20px 0;">
                                  <a href="{{ route('authorize.device', $authorize->token) }}" class="btn-authorize" target="_blank" data-saferedirecturl="{{ route('authorize.device', $authorize->token) }}">
                                    I Authorize This Device
                                  </a>
                                </div>

                                <p>
                                  <a href="{{ route('authorize.device', $authorize->token) }}" target="_blank">{{ route('authorize.device', $authorize->token) }}</a>
                                </p>
                                <p>
                                  Or copy and paste the link above into your browser.
                                </p>
                              </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
