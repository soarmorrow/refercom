<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <?php $except = array('id', 'form_request_id' , 'created_at' , 'updated_at' , 'confirm'); ?>
  <?php $view_fields = array( 'textarea' , 'textfield' , 'checkbox' , 'dropdown', 'radio'); ?>
  <?php 
  $datefrom = new DateTime($seeker->know_from);
  $dateto = new DateTime($seeker->know_to);
  $diff = $datefrom->diff($dateto);
  $dt = new DateTime($request->updated_at);

$thedate = $dt->format('m/d/Y');
   ?>
</head>
  <body>
      <!--    <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="padding: 0 0 30px 0;">
                   
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" >
                        <tr>
                            <td align="center" bgcolor="#ececec" >
                                <img src="{{asset('assets/pdf/header.png')}}" alt="header" width="100%"  />
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ececec" >
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td width="30%">
                                            <center>
                                                <b>Address</b>
                                                <p>5100 Forest Ave, Kansas</p>
                                                <p>City, MO 64110</p><br /><br />
                                                <b>e-mail</b>
                                                <p>info@referecom.com</p><br /><br />
                                                <b>website</b>
                                                <p>www.referecom.com</p>

                                            </center>
                                        </td>
                                        <td width="10">
                                            &nbsp;
                                        </td>
                                        <td width="70%">
                                            <center>
                                                <img src="{{asset('assets/pdf/watermark.png')}}"  alt="watermark" width="200"/>
                                            </center>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td>
                                                        <center>
                                                            <img src="{{asset('assets/pdf/logo.png')}}" alt="header" width="50%"  />
                                                        </center>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p style="word-wrap: break-word;">

                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here...
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here...
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here...
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here...
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                            Content goes here... Content goes here... Content goes here... Content goes here... Content goes here... 
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ececec">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td width="75%">
                                            <img src="{{asset('assets/pdf/footer.png')}}" alt="header" width="100%"  />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                  
                </td>
            </tr>
        </table> -->
  
  <div class="row">
    <div class="col-lg-6">
      <div class="widget-container fluid-height clearfix">
          <div>
          
          </div>
      </div>
    </div>
  </div>








</body>

</html>