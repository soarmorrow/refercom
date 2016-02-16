<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>PDF Design</title>

        <?php $except = array('id', 'form_request_id', 'created_at', 'updated_at', 'confirm'); ?>
        <?php $view_fields = array('textarea', 'textfield', 'checkbox', 'dropdown', 'radio'); ?>
        <?php
        $datefrom = new DateTime($seeker->know_from);
        $dateto = new DateTime($seeker->know_to);
        $diff = $datefrom->diff($dateto);
        $dt = new DateTime($request->updated_at);

        $thedate = $dt->format('m/d/Y');
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>
            *{
                margin: 0;
            }
        </style>
    </head>

    <body>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="padding: 0 0 60px 0;">
                    <!-- Table1 -->
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                        <tr>
                            <td bgcolor="#ececec" style="padding: 10px 20px 10px 20px;"><br />
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #153643; line-height: 10px; font-family: Arial, sans-serif; font-size: 32px;" width="30%">
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
                                        <td style="font-size: 0; line-height: 0;" width="20">
                                            &nbsp;
                                        </td>
                                        <td style=" color: #153643; position: relative; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;" width="70%">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td>
                                                        <center>
                                                            <img src="{{asset('assets/pdf/logo.png')}}" alt="header" width="70%" style="display: block;" />
                                                        </center>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="line-height: 15px; font-size: 32px; text-align: justify"><br />
                                                        <p >{{$thedate}}</p>
                                                        <br />
                                                        <p >{{$request->recipient_first_name}} {{$request->recipient_last_name}}</p>
                                                        <p >{{$request->recipient_position}}</p>
                                                        <p >{{$request->recipient_organisation}}</p>
                                                        <p >{{$request->recipient_address1}}</p>
                                                        <p >{{$request->recipient_zip}}</p>
                                                        <br />
                                                        <p >Dear Sir or Madam,</p>
                                                        <br />
                                                        <p>
                                                           {{$request->description}}
                                                        </p>
                                                        <br />
                                                        <p >{{$request->candidate_skills}}</p>

                                                        <br />
                                                        <p >please do not hesitate to on contacting me at {{$writer->mobile}} or {{$request->writer_email}} if you have any further questions or requests.</p> 
                                                        <br />
                                                        <p >Regards</p>
                                                        <p>

                                                        @if($request->signature)
                                                            <img src="{{ $request->signature }}" />
                                                        @endif

                                                        </p>
                                                        <p >{{$writer->first_name}} {{$writer->last_name}}</p>
                                                        <p >{{$writer->position}}</p>
                                                        <p >{{$writer->organisation}}</p>
                                                        <p >{{$writer->address1}}</p>
                                                        <p >{{$writer->address2}}</p>
                                                        <p >{{$writer->address3}}</p>
                                                        <p >{{$writer->country}}</p>
                                                        <p >{{$writer->zip}}</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <?php for ($i = 0; $i < 15; $i++){echo '<br />';} ?>
                            </td>
                        </tr>
                    </table>
                    <!-- Table1 -->
                </td>
            </tr>
        </table>
    </body>
</html>