@extends('../layouts.front-end')

@section('css')
<style>

</style>

<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />

<link rel="stylesheet" href="css/styleslide.css" type="text/css" media="screen" />



@endsection

@section('content')

	<!-------------------------Begin Right Columns----------------------------->
	<td width="750" align="center" valign="top">
		<!-----------------------------------------------------------Slide Show--------------------------------------------------------------------->
			<table width="752" height="214" background="images/scene_slide.png" cellpadding="0" cellspacing="0"><tr><td align="left" valign="top" style="padding:12px;">
			  <!--/top-->
			  <div id="header"><div class="wrap">
			   <div id="slide-holder">
			<div id="slide-runner">
				
						<a href="admin/" target="_blank"><img id="" src="admin/" class="slide" alt="" width="727" height="193"/></a>
				
			
				<div id="slide-controls">
				 <!--<p id="slide-client" class="text"><strong>post: </strong><span></span></p>
				 <p id="slide-desc" class="text"></p>-->
				 <p id="slide-nav"></p>
				</div>
			</div>
				
				<!--content featured gallery here -->
			   </div>
			  
			  </div></div><!--/header-->
			 </td></tr></table>
		<!-----------------------------------------------------------//Slide--------------------------------------------------------------------->
		<table width="744" align="center" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="28"><img src="images/bgpm_01.png"></td>
				<td width="688"><img src="images/bgpm_02.png"></td>
				<td width="28"><img src="images/bgpm_03.png"></td>
			</tr>
			<tr>
				<td width="28" background="images/bgpm_04.png"></td>
				<td width="688" background="images/bgpm_05.png">
<!------------------------------------------------Begin Show-------------------------------------------------------------->

<center><img src="img/pro-light2.jpg" width="680"></center>
<table width="100%" align="center"><tr><td align="center">
	<form name="searchform" method="post" action="product.php" enctype="multipart/form-data">
	ค้นหาจาก 
	<select name="select_type">
		<option value="0" > เลือกประเภทการค้นหา</option>
		<option value="1" >ชื่อเรื่อง</option>
		<option value="2" >ชื่อซีรีส์</option>
		<option value="3" >นามปากกา</option>
		<option value="4" >สำนักพิมพ์</option>
	</select>
	สิ่งที่ต้องการค้นหา :&nbsp;<input type="text" name="txtsearch" size="10" style="color:blue;text-align:center" value="">&nbsp;<input type="submit" name="submit" value=" ค้นหา ">
	</form>
</td></tr></table>
<table>
	<tr>
		<td align="left" valign="middle"><a href="{{ url('productsSerie') }}"><img src="images/seriebook.jpg" border="0" style="float:left"></a></td>
		<td align="left" valign="middle">
			<div style="width:450px;overflow:hidden;"><center><img src="images/line.png" border="0"></center></div>
				<a href="{{ url('products') }}" class=" product-menu @if($product_type === 'product_normal') product-active @endif ">สินค้าปกติ</a> | 
				<a href="{{ url('productsBlame') }}" class="product-menu @if($product_type === 'product_blame') product-active @endif ">สินค้ามือหนึ่งสภาพเก่า</a> | 
				<a href="{{ url('productsSerie') }}" class="product-menu @if($product_type === 'product_serie') product-active @endif ">ซีรีส์ชุด</a> | 
			    <a href="{{ url('productsBuffet') }}" class="product-menu @if($product_type === 'product_buffet') product-active @endif  ">บุฟเฟ่ต์</a> | 
				<!-- <a href="product_lip.php" class="product-menu">GL ลิปสติก</a> -->
			
			<div style="width:450px;overflow:hidden;"><center><img src="images/line.png" border="0"></center></div>
		</td>
	</tr>
</table>

<table width="100%" border="0">
@php
    $checkpp=1; 
 @endphp
@foreach ($products_alls as $products_all)
@if($checkpp%5 ==1)
        <TR>
@endif
           
                      <td height="20" align="center" valign="top" ><br><br>
					  <table width="130"><tr><td align="left" valign="top">

    @if(!$products_all->picture )
    <img src='img/no_pic.png' WIDTH=100 HEIGHT=125 BORDER=0> 

    @else
			

                    <center><a href="showbook.php?bid={{ $products_all->id_pub }}" target="_blank"><img src="storage/book-images/thumbnail/{{ $products_all->picture }}" WIDTH=100 HEIGHT=145 BORDER=0></a></center><br>
                    <center>
                        <a href="zoom.php?m={{ $products_all->id_pub }}" target="_blank" title="ดูรูปปก"><img src="images/zoom.png" width=16 height=16 border=0></a>
                        
                        @if($products_all->attachment)  
                            &nbsp;<a href="admin/{{ $products_all->attachment }}" target=_blank  title="อ่านเรื่องย่อ"><img src=images/pdf_icon.png border=0 height=16></a>
                            @endif
                            
                            @if($products_all->blog_url)
                                &nbsp;<a href="{{ $products_all->blog_url }}" target=_blank  title="ดู Review Blog"><img src=images/blog_icon.png border=0 height=16></a>
                            @endif

                            @if($products_all->youtube_url)
                                &nbsp;<a href="{{ $products_all->youtube_url }}" target=_blank  title="ดู Review Youtube"><img src=images/youtube_icon.png border=0 height=16></a>
                            @endif
                    </center>
                    <font size=2 color="#ff4bc6">{{ $products_all->book_name }}</font><br>
                    <font color="#7c4eff">{{ $products_all->alias }}</font><br>
                    <font color="#824300">
                                            @if($products_all->writer)
                                                    <b>ซีรีส์ชุด : </b>{{ $products_all->writer }}<br>
                                            @endif

                    </font>
                    <b>ราคา : </b><font color="#FF0000">{{ $products_all->price }}</font> บาท<br>
                    
                    

        @endif 		

                      </td></tr></table>
                      </td>
                                @if($checkpp % 5== 0)
                                    </TR>
                                    @php
                                        $checkpp=0;
                                    @endphp
                                    
                                @endif
                                @php $checkpp++; @endphp
                    
                      
         
@endforeach           
</table>
<br>
<center><img src="images/line.png" border="0"></center>
<center>ทั้งหมด <span class="style4"><b>{{ $products_alls->total() }}</b></span> รายการ <b><br></center>
<center><p align="center">

</p></center>
<div class="text-center">
{{ $products_alls->links() }}
</div>

<!------------------------------------------------End Show------------------------------------------------------------------------>					
				</td>
				<td width="28" background="images/bgpm_06.png"></td>
			</tr>
			<tr>
				<td width="28"><img src="images/bgpm_08.png"></td>
				<td width="688"><img src="images/bgpm_09.png"></td>
				<td width="28"><img src="images/bgpm_10.png"></td>
			</tr>
		</table>

	</td>
	<!-------------------------End Right Columns----------------------------->
    
@endsection
  
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>

<script type="text/javascript" src="js/scripts.js"></script>


<script>

</script> 
@section('js')


@endsection