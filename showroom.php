<html>
<? 

/*
   VER         DATE         AUTHOR            DETAIL
   ---------   -----------  ---------------   ----------------
   1.0         29/01/2008   JHP               New file
   2.0         30/01/2008   JHP               removed 4th parameter from str_replace for older versions of php
*/

$vmPWD="moto";
$vimagefolder="showroom";
$vloadfile=$vimagefolder."/load.txt";
$vcnt=0;

function LoadFile()
{
  extract($GLOBALS);


  $vtr=0;
  $vtd=0;

  $strFilename=$DOCUMENT_ROOT.$vloadfile;
  $oInStream=fopen($strFilename,"r");
  $vCode="<table width='90%' border='0' cellspacing='0' cellpadding='0'>";

  $vlast="table";
  $vGroup="";
  while(!feof($oInStream))
  {

    $strOutput=fgets($oInStream);
	
    if ($strOutput.""=="")
    {
       //Ignores blank lines
    }
      else
    {
	  
      $vinstr = strpos($strOutput,":");

      if ($vinstr > 0)
      {
	    
     	$vTag=substr($strOutput,0,$vinstr);
        $vVal=substr($strOutput,$vinstr+1,(strlen($strOutput)-strlen($vTag))-3);

        switch (strtoupper($vTag))
        {
          case "GROUP":
		    if ($vGroup==$vVal)
			{
			 //do nothing
			}
			else
			{
				$vCode=docleanup($vCode);
				$vCode=$vCode."<tr>";
				$vCode=$vCode."<td colspan='3' class=\"th\">".$vVal."&nbsp;</td>";
				$vCode=$vCode."</tr>";
				$vtd=0;
				$vGroup=$vVal;
			}
            break;
         case "NAME":
            if ($vtd==3)
            {

              $vtd=1;
            }
              else
            {

              $vtd=$vtd+1;
            } 

            if ($vtd==1)
            {

              $vCode=$vCode."<tr><td class=\"tn\">{*vName1*}&nbsp;</td><td class=\"tn\">{*vName2*}&nbsp;</td><td class=\"tn\">{*vName3*}&nbsp;</td></tr>";
              $vCode=$vCode."<tr><td align=\"center\" valign=\"middle\">{*vFile1*}</td><td align=\"center\" valign=\"middle\">{*vFile2*}</td><td align=\"center\" valign=\"middle\">{*vFile3*}</td></tr>";
              $vCode=$vCode."<tr><td wrap=\"True\" class=\"tde\">{*vDetail1*}&nbsp;</td><td class=\"tde\">{*vDetail2*}&nbsp;</td><td class=\"tde\">{*vDetail3*}&nbsp;</td></tr>";
            } 

            $vCode=str_replace("{*vName".$vtd."*}",$vVal,$vCode);
            break;
          case "FILE":
		    $vcriteria="{*vFile".$vtd."*}";
			$vreplaceval="<img height='100' width='150' src='".$vimagefolder."/".$vVal."'";
			$vreplaceval2=" onClick=\"showzoom('".$vimagefolder."/".$vVal."','','','1',500,1,640,480);\">";
            $vCode=str_replace($vcriteria,$vreplaceval.$vreplaceval2,$vCode);
            break;
          case "DETAIL":
            $vCode=str_replace("{*vDetail".$vtd."*}",$vVal,$vCode);
            break; 
			
        } 
        $vlast=$vTag;
	  } 
    } 
  } 
  if ($vlast=="table")
  {
     $vCode=$vCode."<H1>The Showroom is temporarily Empty, please contact the shop for more details on our current specials. </H1>";
  }
  
  $vCode=docleanup($vCode);
  $vCode=$vCode."</tr></table>";
  print $vCode;
  return $function_ret;
} 

function docleanup($vCode)
{
  extract($GLOBALS);

  $vCode=str_replace("{*vName1*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vName2*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vName3*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vFile1*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vFile2*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vFile3*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vDetail1*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vDetail2*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vDetail3*}","&nbsp;",$vCode);
  $function_ret=$vCode;
  return $function_ret;
} 

function Loadall()
{
  extract($GLOBALS);


  $sPath=$DOCUMENT_ROOT."./".$vimagefolder;
  $dir = $sPath;

  $vCode="<table width='90%' border='1' cellspacing='0' cellpadding='0'>";
  $vtr=0;
  $vtd=0;

  // Open a known directory, and proceed to read its contents
  if (is_dir($dir)) {
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) 
		{
			$ftype = strtoupper(substr($file,strrpos($file,".")));
			if ($ftype ==".JPG" || $ftype ==".GIF" || $ftype ==".PNG")
			{
		
			  if ($vtd==3)
			  {
		
				$vtd=1;
			  }
				else
			  {
		
				$vtd=$vtd+1;
			  } 
		
		
			  if ($vtd==1)
			  {
		
				$vCode=$vCode."<tr><td class=\"tn\">{*vName1*}&nbsp;</td><td class=\"tn\">{*vName2*}&nbsp;</td><td class=\"tn\">{*vName3*}&nbsp;</td></tr>";
				$vCode=$vCode."<tr><td align=\"center\" valign=\"middle\">{*vFile1*}</td><td align=\"center\" valign=\"middle\">{*vFile2*}</td><td align=\"center\" valign=\"middle\">{*vFile3*}</td></tr>";
				$vCode=$vCode."<tr><td>{*vBtn1*}</td><td>{*vBtn2*}</td><td>{*vBtn3*}</td></tr>";
			  } 
		
			  $vCode=str_replace("{*vName".$vtd."*}",$file,$vCode);
			  $vCode=str_replace("{*vFile".$vtd."*}","<img height='100' width='150' src='".$vimagefolder."/".$file."' onClick=\"showzoom('".$vimagefolder."/".$file."','','','1',500,1,640,480)\";>",$vCode);
			  $vCode=str_replace("{*vBtn".$vtd."*}","<input type='Button' Language='VBScript' Value='Delete' onclick='m_Deletej(\"".$file."\")'>",$vCode);
		
			}
			  else
			{
			}

		}
		closedir($dh);
	}
  }


  $vCode=str_replace("{*vName1*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vName2*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vName3*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vFile1*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vFile2*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vFile3*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vBtn1*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vBtn2*}","&nbsp;",$vCode);
  $vCode=str_replace("{*vBtn3*}","&nbsp;",$vCode);

  $vCode=$vCode."<tr></tr>";

  $strFilename=$DOCUMENT_ROOT.$vloadfile;
  $oInStream=fopen($strFilename,"r");
  $vTmpstr="";


  while(!feof($oInStream))
  {

    $strOutput=fgets($oInStream);
    if ($vTmpstr.""=="")
    {

      $vTmpstr=$strOutput;
    }
      else
    {

      $vTmpstr=$vTmpstr.$strOutput;
    } 

  } 

  $vCode=$vCode."<tr><td colspan=\"3\">Config:<br><form action=\"showroom.php?pType=S\" method=\"post\"><textarea cols=\"50\" rows=\"10\" name=\"textarea\" id=\"textarea\" text=\"test\">".$vTmpstr."</textarea><input type=\"Submit\" value=\"Save\" ></form></td></tr>";
  $vCode=$vCode."<tr><td colspan=\"3\"><form action=\"showroom.php?pType=Reset\" method=\"post\"><input type=\"Submit\" value=\"Reset Config\" ></form></td></tr>";

  $vCode=$vCode."</table>";
  print $vCode;
  print "<br><br>";
  OutputForm();
  return $function_ret;
} 

function OutputForm()
{
  extract($GLOBALS);

?>
    <form name="frmSend" method="POST" enctype="multipart/form-data" action="showroom.php?pType=U">
	<B>File names:</B><br>
    File 1: <input name="files[]" type="file" size=40><br>
    File 2: <input name="files[]" type="file" size=40><br>
    File 3: <input name="files[]" type="file" size=40><br>
    File 4: <input name="files[]" type="file" size=40><br>
    File 5: <input name="files[]" type="file" size=40><br>
    <br> 
    <input style="margin-top:4" type=submit value="Upload">
    </form>
<? 
  return $function_ret;
} 

function Login()
{
  extract($GLOBALS);

  $vForm="<br><form action=\"showroom.php?pType=A\" method=\"post\">Admin password: <input type=\"password\" name=\"fPWD\" size=\"20\" /><input type=\"submit\" value=\"Submit\" />   </form>";
  print $vForm;
  return $function_ret;
} 

function SaveFiles()
{
  extract($GLOBALS);

	foreach ($_FILES["files"]["error"] as $key => $error) {
		if ($error == UPLOAD_ERR_OK) {
			$tmp_name = $_FILES["files"]["tmp_name"][$key];
			$name = $_FILES["files"]["name"][$key];
			move_uploaded_file($tmp_name, $vimagefolder."/$name");
		}
	}

  return $function_ret;
} 

?>
<head>

<link type="text/css"  href="css/floater.css" rel="stylesheet" />
<link type="text/css"  href="css/moto.css" rel="stylesheet" />
<script language="javascript" src="js/imagefloat.js" type="text/javascript"></script>

<title>www.MOTOPASSION.co.za</title>

<script language="Javascript">
function m_Deletej(vName){
   var vres; 
   var vfl;
   
   vres = window.confirm('Delete File???: '+vName+'');
   if (vres){
      window.location = "showroom.php?pType=UNL&pFile="+vName+"";
   }else{
      alert ('Delete Canceled');	  
   };
};
</script>

</head>

<body>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="10">&nbsp;</td>
    <td height="10"></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td align="center"><img src="images/logo.jpg" alt="Motopassion Logo" width="680" height="97" /></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td align="center"><img src="images/slogan.jpg" alt="Motopassion Slogan]'" width="305" height="51" /></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td align="center"><img src="images/brand_bikes.jpg" alt="motopassion brand bikes" width="680" height="95" /></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td width="10">&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="120" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" bgcolor="#CC0000"><span class="style1">MENU</span></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#CCCCCC" class="button" onMouseOver="this.className='buttonover';" onMouseOut="this.className='button';"><a href="index.htm">Home</a></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#FF6600" class="button" onMouseOver="this.className='buttonover';" onMouseOut="this.className='button';">Showroom</td>
          </tr>
          <tr>
            <td align="center" bgcolor="#CCCCCC" class="button" onMouseOver="this.className='buttonover';" onMouseOut="this.className='button';"><a href="contactus.htm">Contact Us</a></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#CCCCCC" class="button" onMouseOver="this.className='buttonover';" onMouseOut="this.className='button';"><a href="safety.htm">Driver Safety</a></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#CCCCCC" class="button" onMouseOver="this.className='buttonover';" onMouseOut="this.className='button';"><a href="map.htm">Map</a></td>
          </tr>
          
        </table></td>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" bgcolor="#CC0000"><span class="style1">SHOWROOM</span></td>
            <td align="right" bgcolor="#CC0000" width="50"><span class="log"><a href="showroom.php?pType=L">Login</a>&nbsp;|&nbsp;<a href="showroom.php">Logout</a></span></td>
          </tr>
          <tr>
            <td width="18%" align="center" colspan="2">
			
			<? 

			$vType=htmlspecialchars($_GET["pType"]);
			$vunlFile=htmlspecialchars($_GET["pFile"]);
			
			switch ($vType){
			case 'A' : //A - Authorise
				$vPWD=$_POST["fPWD"];
				if ($vPWD.""==$vmPWD)
				{
					LoadAll();
				}
				else
				{
					print "<br><H1>Invalid Password</H1>";
				} 
				break;
			case 'L' : //L - Login
				Login();
				break;
			case 'U' : //U - Update
				print "<br><H1>File(s) Uploaded</H1>";
				SaveFiles();
				LoadAll();
				break;
			case 'R' : //R - Reload
				LoadAll();
				break;
			case 'S' : //S - Save Script
				$vqStr=$_POST["textarea"];
				$vFl=$DOCUMENT_ROOT."showroom/load.txt";
				$oTextFileo=fopen($vFl,"w");
				fputs($oTextFileo,$vqStr);
				fclose($oTextFileo);
				$oTextFileo=null;
				LoadAll();
				break;
			case 'Reset' : //Reset - Reset Script
				$vFl=$DOCUMENT_ROOT."showroom/load.txt";
				$oTextFileo=fopen($vFl,"w");
				fputs($oTextFileo,"GROUP:Group1"."\r\n"."NAME:Name1"."\r\n"."FILE:File1"."\r\n"."DETAIL:Detail1");
				fclose($oTextFileo);
				$oTextFileo=null;
				LoadAll();
				break;
			case 'UNL' : //UNL - Unlink/Delete Image
				unlink($vimagefolder."/".$vunlFile); 
				print "<br><H1>File Delete</H1>";
				LoadAll();
				break;
			default :
			  LoadFile();
			}
			
			?>			
			&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      
    </table></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center"><span class="copyright style2">&copy; BEMAD</span></td>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>
