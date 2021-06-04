@extends('../layouts.front-ebook')

@section('menu_rule_ebook' , 'active_nav')

@section('css')

<style>

.linear-2 {
  background-image: linear-gradient(to left, #23074d , #cc5333);
}
.diamond{
    counter-reset: list-counter;
    list-style: none;
    float:left;
}
.diamond li{
    margin: 1em 0;    
}
.diamond li:before{
    content: "";
    transform: rotate(45deg);
    text-transform: rotate(90deg);
    width: .5em;
    height: .5em;
    padding: .3em;
    margin-right: 1em;
    border: .1em solid #41f4b2;
    background: #4286f4;
    display: inline-block;
    
}
</style>
@endsection



@section('content')
<section>
    <div class="py-4">
        <center>
            <h1>
            <strong>
            Rule
            </strong><br/>
            </h1>
        </center>
    </div>
    <div class="container">
        <div class="row justify-content-center p-3">
            <div class="col-md-12">
                <div class="card" style="border-left:0;border-right:0;">
                    <div class="card-header" >
                            <div class="head_text">
                                <div class="head_text_string ">
                                        <h2>กฎกติกา [ ทั้งหมด ]</h2>
                                </div>
                            </div>
                            
                    </div>
                    <div class="card-body ">
                        
                        
                        <ul class="diamond">
                        @foreach ($privacys as $privacy)
                            <li>
                                <a href="{{ url('ebook/rule/'.$privacy->id) }}"  style="color:black">{{ $privacy->news_title }}</a>
                            </li>
                        @endforeach  
                        </ul>
                        
                            
                        
                    </div>
                </div>
            </div>
        </div>     
    </div>
</section>

@endsection



@section('js')
    


<script>


// end jquery
    
</script>
@endsection
