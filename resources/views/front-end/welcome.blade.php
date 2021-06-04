@extends('../layouts.front-end')

@section('css')
<style>

</style>
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
	
				<div id="slide-controls">
				 <!--<p id="slide-client" class="text"><strong>post: </strong><span></span></p>
				 <p id="slide-desc" class="text"></p>-->
				 <p id="slide-nav"></p>
				</div>
			</div>
				
				<!--content featured gallery here -->
			   </div>
			   <script type="text/javascript">


			   </script>
			  </div></div><!--/header-->
			 </td></tr></table>


        <!---------------------------------Start newfiction--------------------------------------------------->


<table width="228" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="25"><img src="images/bgnewfict_01.png"></td>
		<td width="687" background="images/bgnewfict_02.png" align="right" valign="bottom"><a href="{{ url('products')  }}"><img src="images/viewall.gif" border="0"></a></td>
		<td width="29"><img src="images/bgnewfict_03.png"></td>
	</tr>
	<tr>
		<td><img src="images/bgnewfict_04.png"></td>
		<td background="images/bgnewfict_05.png" valign="top">
<!----------------------------------แสดงหนังสือ----------------------------------------->


<table width="100%" border="0">
@php
    $checkpp=1; 
 @endphp
@foreach ($products_news as $products_new)
@if($checkpp%5 ==1)
        <TR>
@endif
           
                      <td height="20" align="center" valign="top" ><br><br>
					  <table width="130"><tr><td align="left" valign="top">

    @if(!$products_new->picture )
    <img src="{{ url('img/no_pic.png') }}" WIDTH=100 HEIGHT=125 BORDER=0> 

    @else
			

                    <center><a href="showbook.php?bid={{ $products_new->id_pub }}" target="_blank"><img src="storage/book-images/thumbnail/{{ $products_new->picture }}" WIDTH=100 HEIGHT=145 BORDER=0></a></center><br>
                    <center>
                        <a href="zoom.php?m={{ $products_new->id_pub }}" target="_blank" title="ดูรูปปก"><img src="images/zoom.png" width=16 height=16 border=0></a>
                        
                        @if($products_new->attachment)  
                            &nbsp;<a href="admin/{{ $products_new->attachment }}" target=_blank  title="อ่านเรื่องย่อ"><img src=images/pdf_icon.png border=0 height=16></a>
                            @endif
                            
                            @if($products_new->blog_url)
                                &nbsp;<a href="{{ $products_new->blog_url }}" target=_blank  title="ดู Review Blog"><img src=images/blog_icon.png border=0 height=16></a>
                            @endif

                            @if($products_new->youtube_url)
                                &nbsp;<a href="{{ $products_new->youtube_url }}" target=_blank  title="ดู Review Youtube"><img src=images/youtube_icon.png border=0 height=16></a>
                            @endif
                    </center>
                    <font size=2 color="#ff4bc6">{{ $products_new->book_name }}</font><br>
                    <font color="#7c4eff">{{ $products_new->alias }}</font><br>
                    <font color="#824300">
                                            @if($products_new->writer)
                                                    <b>ซีรีส์ชุด : </b>{{ $products_new->writer }}<br>
                                            @endif

                    </font>
                    <b>ราคา : </b><font color="#FF0000">{{ $products_new->price }}</font> บาท<br>
                    
                    

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

<!--------------------จบแสดงหนังสือ-------------------------------->	
		</td>
		<td><img src="images/bgnewfict_06.png"></td>
	</tr>
	<tr>
		<td><img src="images/bgnewfict_07.png"></td>
		<td><img src="images/bgnewfict_08.png"></td>
		<td><img src="images/bgnewfict_09.png"></td>
	</tr>
</table>

 <!---------------------------------end newfiction--------------------------------------------------->





 <!---------------------------------Start bestseller--------------------------------------------------->


 <table width="228" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="25"><img src="images/bgbestseller_01.png"></td>
		<td width="687" background="images/bgbestseller_02.png" align="right" valign="bottom"><a href="best.php"><img src="images/viewall.gif" border="0"></a></td>
		<td width="29"><img src="images/bgbestseller_03.png"></td>
	</tr>
	<tr>
		<td><img src="images/bgbestseller_04.png"></td>
		<td background="images/bgbestseller_05.png" valign="top">


<table width="100%" border="0">
                
</table>


<!--จบแสดงหนังสือ-->
		</td>
		<td><img src="images/bgbestseller_06.png"></td>
	</tr>
	<tr>
		<td><img src="images/bgbestseller_07.png"></td>
		<td><img src="images/bgbestseller_08.png"></td>
		<td><img src="images/bgbestseller_09.png"></td>
	</tr>
</table>



 <!---------------------------------end bestseller--------------------------------------------------->



  <!---------------------------------Start waitfiction--------------------------------------------------->

        <table width="228" align="center" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td width="25"><img src="images/bgwait_01.png"></td>
                <td width="687" background="images/bgwait_02.png" align="right" valign="bottom"><a href="wait.php"><img src="images/viewall.gif" border="0"></a></td>
                <td width="29"><img src="images/bgwait_03.png"></td>
            </tr>
            <tr>
                <td><img src="images/bgwait_04.png"></td>
                <td background="images/bgwait_05.png" valign="top">
        <!----------------------------------แสดงหนังสือ----------------------------------------->


        <table width="100%" border="0">
         <TR>
         
                            <td height="20" align="center" valign="top" ><br><br>
                            <table width="130"><tr><td align="left" valign="top">
                              
                    <img src='admin/admin/no_pic.jpg' WIDTH=100 HEIGHT=125 BORDER=0>
                              
            <center><a href=showwait.php?bid= target="_blank"><img src="admin/" WIDTH=100 HEIGHT=145 BORDER=0></a></center><br>
            <center><a href="zoom.php?m=" target="_blank"><img src="images/zoom.png" width=16 height=16 border=0> Zoom</a></center>
            
            <font size=2 color="#ff4bc6">444444</font><br>
            <font color="#7c4eff">55555555</font><br>
            <font color="#824300">
                                        <b>ซีรีส์ชุด : </b> 66666<br>";
                                           
            </font>

       
                            </td></tr></table>
                            </td>
                            
               </TR>
                                                        
        </table>


        <!--------------------จบแสดงหนังสือ-------------------------------->
                </td>
                <td><img src="images/bgwait_06.png"></td>
            </tr>
            <tr>
                <td><img src="images/bgwait_07.png"></td>
                <td><img src="images/bgwait_08.png"></td>
                <td><img src="images/bgwait_09.png"></td>
            </tr>
        </table>


  <!---------------------------------end waitfiction--------------------------------------------------->

        <br>
        


	</td>

</tr>
<tr><td colspan="2">
    
@endsection

@section('js')


@endsection