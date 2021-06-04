@extends('../layouts.front-ebook')

@section('menu_products_ebook' , 'active_nav')

@section('css')
<style>
.pagination {
    justify-content: center;
}
.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 10px;
    padding-left: 10px;
}
.linear-5 {
    background: rgb(102,25,185);
    background: radial-gradient(circle, rgba(102,25,185,1) 0%, rgba(25,182,223,1) 50%, rgba(42,124,222,1) 100%);
    padding-top: 20px ;
    padding-bottom: 20px;
    border: 2px solid Purple;
}
.filter-control {
    text-align: center;
    margin-bottom: 10px;
    padding-top: 10px;
}
/* header */
.breadcrumb {
    margin-bottom: 0rem;
}
.option_head_text {
    align-items: center;
    /* position: absolute; */
    right: 0;
    bottom: 7px;
    /* font-family: Helvetica,Thonburi,Tahoma,sans-serif; */
    font-size: 20px;
    /* color: red; */
}
.head_text {
    border-bottom: 1px solid #8e918f;
    /* padding-bottom: 5px; */
    margin-bottom: 20px;
    position: relative;
}

.option_head_text a {
    color: black;
}
.card { 
    border: 0;
   
}
.card-header {
    padding: 0;
}
.card-body {
    padding: 0;
}
.card-footer {
    padding: 0;
}
.btn {
    padding: 0;
}
/* Sale Styling */
.price-sale .price-amount {
  color: gray;
  text-decoration: line-through;
}
.price-sale .price-sale-amount {
  color: red;
}
.price del {
  color: rgba(128, 128, 128, 0.5);
  text-decoration: none;
  position: relative;
  font-size: 18px;
  font-weight: 100;
}
.price del:before {
  content: " ";
  display: block;
  width: 100%;
  border-top: 2px solid rgba(255, 0, 0, 0.9);
  /* height: 10px; */
  position: absolute;
  bottom: 13px;
  left: 0;
  transform: rotate(-25deg);
}
.price ins {
  font-size: 80px;
  font-weight: 100;
  text-decoration: none;
  padding: 0 0 0 0.5em;
}
.parent {
  overflow: hidden; /* required */
  /* width: 50%; for demo only */
  /* height: 250px some non-zero number; */
  /* margin: 25px auto; for demo only */
  border:1px solid grey;/* for demo only*/
  position: relative; /* required  for demo*/
}

.ribbon {
  margin: 0;
  padding: 0;
  background: DarkRed;
  color:white;
  padding:1em 0;
  position: absolute;
  top:0;
  right:0;
  transform: translateX(30%) translateY(0%) rotate(45deg);
  transform-origin: top left;
}
.ribbon:before,
.ribbon:after {
  content: '';
  position: absolute;
  top:0;
  margin: 0 -1px; /* tweak */
  width: 100%;
  height: 100%;
  background: DarkRed;
}
.ribbon:before {
  right:100%;
}
.disabled{
    position: relative;
}
.disabled:after{
    content: "";
    position: absolute;
    width: 100%;
    height: inherit;
    background-color: rgba(0,0,0,0.1);
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}
a:hover{
    /* background-color: #7CFC00 !important; */
    text-shadow: 0 0 0.9em #F9629F;
}














.card-body {
    padding: 0;
    padding-top: 70%;
}


.rcorners {
    border-radius: 20px;
}
.rcorners2 {
    border-radius: 10px;
}


.card {
  margin-top: 200px;
  /* padding-top: 30px; */
  width: 100%;
  /* border: 2px solid green; */
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
}
.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}
.card-img-top {
    position: absolute;
  top: -50%;
  /* top: 65%; */
  left: 10%;
  /* margin-left: -100px; */
  /* width: 60px !important; */
  /* height: 60px; */
  /* background-color: red */
}

card-img, .card-img-bottom, .card-img-top {
    flex-shrink: 0;
    width: 80%;
    /* height: 100%; */
}


/* @media */
@media screen and (max-width: 2000px){
    .card-img-top-best {
    position: absolute;
    top: 60%;
    left: 10%;
    flex-shrink: 0;
    width: 80%;
        /* top: 55%; */
    }
    .owl-carousel .owl-stage-outer {
        padding-bottom:15%;
    }
}
@media screen and (max-width: 992px) {
    .card-img-top-best {
        position: absolute;
  top: 60%;
  left: 10%;
  flex-shrink: 0;
    width: 80%;
        /* top: 55%; */
    }
    .owl-carousel .owl-stage-outer {
        padding-bottom:30%;
    }
    .card-img-top{
        padding: 5%;
    }
}
@media screen and (max-width: 768px) {
    .card-img-top-best {
        position: absolute;
  top: 55%;
  left: 10%;
  flex-shrink: 0;
    width: 80%;
        /* top: 50%; */
    }
    .owl-carousel .owl-stage-outer {
        padding-bottom:40%;
    }
    .card-img-top{
        padding: 5%;
    }
}
@media screen and (max-width: 576px) {
    .card-img-top-best {
        position: absolute;
  top: 70%;
  left: 10%;
  flex-shrink: 0;
    width: 80%;
        /* top: 80%; */
    }
    .owl-carousel .owl-stage-outer {
        padding-bottom:30%;
    }
    .card-img-top{
        padding: 10%;
    }
}
@media only screen and (max-width: 480px) {
    .card-img-top-best {
        position: absolute;
  top: 65%;
  left: 10%;
  flex-shrink: 0;
    width: 80%;
        /* top: 80%; */
    }
    .owl-carousel .owl-stage-outer {
        padding-bottom:50%;
    }
    .card-img-top{
        padding: 10%;
    }
    
}








/* book 3D */
.book3d {
	 position: relative;
	 display: inline-block;
	 width: 0;
	 height: 0;
	 padding: 70% 50%;
	 margin: 12.5% 0;
	 -webkit-perspective: 1800px;
	 -moz-perspective: 1800px;
	 perspective: 1800px;
	 -webkit-transform-style: preserve-3d;
	 -moz-transform-style: preserve-3d;
	 transform-style: preserve-3d;
	 cursor: pointer;
}
 .book3d ul {
	 list-style: none;
}
 .book3d::after {
	 content: "";
	 position: absolute;
	 width: 97.5%;
	 height: 20%;
	 background-color: rgba(25, 25, 25, 0.15);
	 transform: rotateZ(6deg) rotateX(70deg) rotateY(0deg);
	 box-shadow: 0 0 10px 5px rgba(25, 25, 25, 0.15);
	 left: 0;
	 top: 90%;
	 -webkit-transition: all 0.8s ease;
	 -moz-transition: all 0.8s ease;
	 transition: all 0.8s ease;
	 mix-blend-mode: screen;
}
 .book3d .hardcover_front {
	 -webkit-transform: rotateY(-36deg) translateZ(-6px);
	 -moz-transform: rotateY(-36deg) translateZ(-6px);
	 transform: rotateY(-36deg) translateZ(-6px);
	 z-index: 100;
	 position: absolute;
	 top: 0;
	 left: 0;
	 width: 100%;
	 height: 100%;
	 -webkit-transform-style: preserve-3d;
	 -moz-transform-style: preserve-3d;
	 transform-style: preserve-3d;
	 -webkit-transform-origin: 0% 100%;
	 -moz-transform-origin: 0% 100%;
	 transform-origin: 0% 100%;
	 -webkit-transition: all 0.8s ease, z-index 0.6s;
	 -moz-transition: all 0.8s ease, z-index 0.6s;
	 transition: all 0.8s ease, z-index 0.6s;
}
 .book3d .hardcover_front li {
	 position: absolute;
	 top: 0;
	 left: 0;
	 width: 100%;
	 height: 100%;
	 -webkit-transform-style: preserve-3d;
	 -moz-transform-style: preserve-3d;
	 transform-style: preserve-3d;
}
 .book3d .hardcover_front li:first-child {
	 background-color: #eee;
	 background-size: 100% 100%;
	 background-position: center;
	 -webkit-backface-visibility: hidden;
	 -moz-backface-visibility: hidden;
	 backface-visibility: hidden;
	 -webkit-user-select: none;
	 -moz-user-select: none;
	 user-select: none;
	 -webkit-transform: translateZ(4px);
	 -moz-transform: translateZ(4px);
	 transform: translateZ(4px);
}
 .book3d .hardcover_front li:first-child:after {
	 background: #999;
	 position: absolute;
	 top: 0;
	 left: 0;
	 width: 4px;
	 height: 100%;
	 -webkit-transform: rotateY(90deg) translateZ(-2px) translateX(2px);
	 -moz-transform: rotateY(90deg) translateZ(-2px) translateX(2px);
	 transform: rotateY(90deg) translateZ(-2px) translateX(2px);
}
 .book3d .hardcover_front li:first-child:before {
	 background: #999;
	 position: absolute;
	 top: 0;
	 left: 0;
	 width: 4px;
	 height: 100%;
	 -webkit-transform: rotateY(90deg) translateZ(158px) translateX(2px);
	 -moz-transform: rotateY(90deg) translateZ(158px) translateX(2px);
	 transform: rotateY(90deg) translateZ(158px) translateX(2px);
}
 .book3d .hardcover_front li:last-child {
	 background: #fffbec;
	 -webkit-transform: rotateY(180deg) translateZ(-3px);
	 -moz-transform: rotateY(180deg) translateZ(-3px);
	 transform: rotateY(180deg) translateZ(-3px);
}
 .book3d .hardcover_front li:last-child:after {
	 background: #999;
	 position: absolute;
	 top: 0;
	 left: 0;
	 width: 4px;
	 height: 160px;
	 -webkit-transform: rotateX(90deg) rotateZ(90deg) translateZ(80px) translateX(-2px) translateY(-78px);
	 -moz-transform: rotateX(90deg) rotateZ(90deg) translateZ(80px) translateX(-2px) translateY(-78px);
	 transform: rotateX(90deg) rotateZ(90deg) translateZ(80px) translateX(-2px) translateY(-78px);
}
 .book3d .hardcover_front li:last-child:before {
	 background: #999;
	 position: absolute;
	 top: 0;
	 left: 0;
	 width: 4px;
	 height: 160px;
	 box-shadow: 0px 0px 30px 5px #333;
	 -webkit-transform: rotateX(90deg) rotateZ(90deg) translateZ(-140px) translateX(-2px) translateY(-78px);
	 -moz-transform: rotateX(90deg) rotateZ(90deg) translateZ(-140px) translateX(-2px) translateY(-78px);
	 transform: rotateX(90deg) rotateZ(90deg) translateZ(-140px) translateX(-2px) translateY(-78px);
}
 .book3d .hardcover_back {
	 -webkit-transform: rotateY(-21deg) translateZ(-8px);
	 -moz-transform: rotateY(-21deg) translateZ(-8px);
	 transform: rotateY(-21deg) translateZ(-8px);
	 position: absolute;
	 top: 0;
	 left: 0;
	 width: 100%;
	 height: 100%;
	 -webkit-transform-style: preserve-3d;
	 -moz-transform-style: preserve-3d;
	 transform-style: preserve-3d;
	 -webkit-transform-origin: 0% 100%;
	 -moz-transform-origin: 0% 100%;
	 transform-origin: 0% 100%;
}
 .book3d .hardcover_back li {
	 position: absolute;
	 top: 0;
	 left: 0;
	 width: 100%;
	 height: 100%;
	 -webkit-transform-style: preserve-3d;
	 -moz-transform-style: preserve-3d;
	 transform-style: preserve-3d;
}
 .book3d .hardcover_back li:first-child {
	 background: #fffbec;
	 -webkit-transform: translateZ(2px);
	 -moz-transform: translateZ(2px);
	 transform: translateZ(2px);
}
 .book3d .hardcover_back li:first-child:after {
	 background: #999;
	 position: absolute;
	 top: 0;
	 left: 0;
	 width: 4px;
	 height: 100%;
	 -webkit-transform: rotateY(90deg) translateZ(-2px) translateX(2px);
	 -moz-transform: rotateY(90deg) translateZ(-2px) translateX(2px);
	 transform: rotateY(90deg) translateZ(-2px) translateX(2px);
}
 .book3d .hardcover_back li:first-child:before {
	 background: #999;
	 position: absolute;
	 top: 0;
	 left: 0;
	 width: 4px;
	 height: 100%;
	 -webkit-transform: rotateY(90deg) translateZ(158px) translateX(2px);
	 -moz-transform: rotateY(90deg) translateZ(158px) translateX(2px);
	 transform: rotateY(90deg) translateZ(158px) translateX(2px);
}
 .book3d .hardcover_back li:last-child {
	 background: #fffbec;
	 -webkit-transform: translateZ(-2px);
	 -moz-transform: translateZ(-2px);
	 transform: translateZ(-2px);
}
 .book3d .hardcover_back li:last-child:after {
	 background: #999;
	 position: absolute;
	 top: 0;
	 left: 0;
	 width: 4px;
	 height: 160px;
	 -webkit-transform: rotateX(90deg) rotateZ(90deg) translateZ(80px) translateX(2px) translateY(-78px);
	 -moz-transform: rotateX(90deg) rotateZ(90deg) translateZ(80px) translateX(2px) translateY(-78px);
	 transform: rotateX(90deg) rotateZ(90deg) translateZ(80px) translateX(2px) translateY(-78px);
}
 .book3d .hardcover_back li:last-child:before {
	 background: #999;
	 position: absolute;
	 top: 0;
	 left: 0;
	 width: 4px;
	 height: 160px;
	 box-shadow: 10px -1px 80px 20px #666;
	 -webkit-transform: rotateX(90deg) rotateZ(90deg) translateZ(-140px) translateX(2px) translateY(-78px);
	 -moz-transform: rotateX(90deg) rotateZ(90deg) translateZ(-140px) translateX(2px) translateY(-78px);
	 transform: rotateX(90deg) rotateZ(90deg) translateZ(-140px) translateX(2px) translateY(-78px);
}
 .book3d .page {
	 position: absolute;
	 top: 0;
	 left: 0;
	 -webkit-transform-style: preserve-3d;
	 -moz-transform-style: preserve-3d;
	 transform-style: preserve-3d;
	 width: 100%;
	 height: 98%;
	 top: 1.5%;
	 left: 3%;
	 z-index: 10;
	 -webkit-transform: translateZ(-2px);
	 -moz-transform: translateZ(-2px);
	 transform: translateZ(-2px);
}
 .book3d .page > li {
	 background: -webkit-linear-gradient(left, #e1ddd8 0%, #fffbf6 100%);
	 background: -moz-linear-gradient(left, #e1ddd8 0%, #fffbf6 100%);
	 background: -ms-linear-gradient(left, #e1ddd8 0%, #fffbf6 100%);
	 background: linear-gradient(left, #e1ddd8 0%, #fffbf6 100%);
	 box-shadow: inset 0px -1px 2px rgba(50, 50, 50, 0.1), inset -1px 0px 1px rgba(150, 150, 150, 0.2);
	 border-radius: 0px 5px 5px 0px;
	 position: absolute;
	 top: 0;
	 left: 0;
	 -webkit-transform-style: preserve-3d;
	 -moz-transform-style: preserve-3d;
	 transform-style: preserve-3d;
	 width: 100%;
	 height: 100%;
	 -webkit-transform-origin: left center;
	 -moz-transform-origin: left center;
	 transform-origin: left center;
	 -webkit-transition-property: transform;
	 -moz-transition-property: transform;
	 transition-property: transform;
	 -webkit-transition-timing-function: ease;
	 -moz-transition-timing-function: ease;
	 transition-timing-function: ease;
}
 .book3d .page > li:nth-child(1) {
	 -webkit-transition-duration: 0.6s;
	 -moz-transition-duration: 0.6s;
	 transition-duration: 0.6s;
}
 .book3d .page > li:nth-child(2) {
	 -webkit-transition-duration: 0.6s;
	 -moz-transition-duration: 0.6s;
	 transition-duration: 0.6s;
}
 .book3d .page > li:nth-child(3) {
	 -webkit-transition-duration: 0.4s;
	 -moz-transition-duration: 0.4s;
	 transition-duration: 0.4s;
}
 .book3d .page > li:nth-child(4) {
	 -webkit-transition-duration: 0.5s;
	 -moz-transition-duration: 0.5s;
	 transition-duration: 0.5s;
}
 .book3d .page > li:nth-child(5) {
	 -webkit-transition-duration: 0.6s;
	 -moz-transition-duration: 0.6s;
	 transition-duration: 0.6s;
}
 .book3d .page li:nth-child(1) {
	 -webkit-transform: rotateY(-28deg);
	 -moz-transform: rotateY(-28deg);
	 transform: rotateY(-28deg);
}
 .book3d .page li:nth-child(2) {
	 -webkit-transform: rotateY(-30deg);
	 -moz-transform: rotateY(-30deg);
	 transform: rotateY(-30deg);
}
 .book3d .page li:nth-child(3) {
	 -webkit-transform: rotateY(-32deg);
	 -moz-transform: rotateY(-32deg);
	 transform: rotateY(-32deg);
}
 .book3d .page li:nth-child(4) {
	 -webkit-transform: rotateY(-34deg);
	 -moz-transform: rotateY(-34deg);
	 transform: rotateY(-34deg);
}
 .book3d .page li:nth-child(5) {
	 -webkit-transform: rotateY(-36deg);
	 -moz-transform: rotateY(-36deg);
	 transform: rotateY(-36deg);
}
 .book3d:hover::after {
	 transform: rotateZ(10deg) rotateX(50deg) rotateY(0deg);
}
 .book3d:hover > .hardcover_front {
	 -webkit-transform: rotateY(-55deg) translateZ(-6px);
	 -moz-transform: rotateY(-55deg) translateZ(-6px);
	 transform: rotateY(-55deg) translateZ(-6px);
	 z-index: 0;
}
 .book3d:hover > .page li:nth-child(1) {
	 -webkit-transform: rotateY(-30deg);
	 -moz-transform: rotateY(-30deg);
	 transform: rotateY(-30deg);
	 -webkit-transition-duration: 1.5s;
	 -moz-transition-duration: 1.5s;
	 transition-duration: 1.5s;
}
 .book3d:hover > .page li:nth-child(2) {
	 -webkit-transform: rotateY(-35deg);
	 -moz-transform: rotateY(-35deg);
	 transform: rotateY(-35deg);
	 -webkit-transition-duration: 1.8s;
	 -moz-transition-duration: 1.8s;
	 transition-duration: 1.8s;
}
 .book3d:hover > .page li:nth-child(3) {
	 -webkit-transform: rotateY(-40deg);
	 -moz-transform: rotateY(-40deg);
	 transform: rotateY(-40deg);
	 -webkit-transition-duration: 1.6s;
	 -moz-transition-duration: 1.6s;
	 transition-duration: 1.6s;
}
 .book3d:hover > .page li:nth-child(4) {
	 -webkit-transform: rotateY(-45deg);
	 -moz-transform: rotateY(-45deg);
	 transform: rotateY(-45deg);
	 -webkit-transition-duration: 1.4s;
	 -moz-transition-duration: 1.4s;
	 transition-duration: 1.4s;
}
 .book3d:hover > .page li:nth-child(5) {
	 -webkit-transform: rotateY(-50deg);
	 -moz-transform: rotateY(-50deg);
	 transform: rotateY(-50deg);
	 -webkit-transition-duration: 1.2s;
	 -moz-transition-duration: 1.2s;
	 transition-duration: 1.2s;
}
















.product_img {
	 /* width: 300px; */
	 /* height: 300px; */
	 position: relative;
	 display: inline-block;
	 overflow: hidden;
}
 .product_img .caption {
	 width: 0;
	 height: 0;
	 position: absolute;
	 left: 50%;
	 top: 50%;
	 transform: translate(-50%, -50%);
	 display: block;
	 background: white  ;
	 opacity: 0;
	 visibility: hidden;
	 transition: all 0.3s ease-in-out;
     border-radius: 10px;
}
 .product_img:hover .caption {
	 opacity: 1;
	 visibility: visible;
	 width: 80%;
	 height: 80%;
}
 .product_img.two .caption {
	 transform: none;
	 opacity: 0;
	 visibility: hidden;
	 left: 0;
	 top: inherit;
	 bottom: -50px;
	 width: 100%;
	 height: 70px;
     
    /* padding-right: 15px;
    padding-left: 15px; */
    /* margin-left: 15px;
    margin-right: 15px; */
}
 .product_img.two:hover .caption {
	 bottom: 0;
	 opacity: 1;
	 visibility: visible;
}
.shadow1{
    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
}

/* start state */
.mfp-zoom-out {
	/* animate in */
	/* animate out */
}
 .mfp-zoom-out .mfp-with-anim {
	 opacity: 0;
	 transition: all 0.3s ease-in-out;
	 transform: scale(1.3);
}
 .mfp-zoom-out.mfp-bg {
	 opacity: 0;
	 transition: all 0.3s ease-out;
}
 .mfp-zoom-out.mfp-ready .mfp-with-anim {
	 opacity: 1;
	 transform: scale(1);
}
 .mfp-zoom-out.mfp-ready.mfp-bg {
	 opacity: 0.8;
}
 .mfp-zoom-out.mfp-removing .mfp-with-anim {
	 transform: scale(1.3);
	 opacity: 0;
}
 .mfp-zoom-out.mfp-removing.mfp-bg {
	 opacity: 0;
}
 





.icon_heart {
    font-size: 20px;
    color: #252525;
    position: absolute;
    right: 20px;
    /* left: 20px; */
    top: -15px;
    cursor: pointer;
    -webkit-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
    opacity: 0;
}
.shape:hover .icon_heart {
    top: 15px;
	opacity: 1;
}

.product-item:hover .icon_heart {
	top: 15px;
	opacity: 1;
}

.fa-heart-book {
  display: inline-block;
  border-radius: 100%;
  box-shadow: 0px 0px 2px black;
  padding: 0.3em 0.4em;

}






.pagination {
	 display: flex;
}
 .pagination .page-link {
	 text-align: center;
	 /* padding: 0.6rem; */
	 border-radius: 50%;
	 /* width: 2rem; */
	 /* height: 2rem; */
	 font-size: 1rem;
	 font-weight: 700;
	 /* line-height: 1.9; */
	 margin: 0.3rem;
	 border: 1px solid #f4f6fa;
	 background: #f4f6fa;
}
 @media (max-width: 480px) {
	 .pagination .page-link {
		 width: 2rem;
		 height: 2rem;
		 font-size: 1rem;
		 padding: 0.5rem;
	}
}
 .pagination .page-link.active {
	 color: #fff;
	 background: #00aaf1;
}
 .pagination .page-link i {
	 font-size: 1em;
	 line-height: 0.8em;
     
}
 .pagination a {
	 color: #000;
	 text-decoration: none;
	 transition: all 0.4s;
}
 .pagination a:hover {
	 color: #fff;
	 background: #00aaf1;
}
 .pagination.pagination--left {
	 justify-content: flex-start;
}
 .pagination.pagination--center {
	 justify-content: center;
}
 .pagination.pagination--right {
	 justify-content: flex-end;
}
 


</style>
@endsection

@section('content')

    <section class="women-banner spad">
        <div class="py-4">
            <center>
                <h1>
                <strong>
                E-Books
                </strong><br/>
                </h1>
            </center>
        </div>
        <div class="container">
            <div class="head_text">
                <div class="head_text_string row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <h2>{{ $head_text ?? '' }} [ ทั้งหมด ]</h2>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 collapse" id="collapseExample">
                        @if(!empty($book_types))
                        <div class="mt-4">
                            @foreach ($book_types as $book_type)
                        <a href="{{ url('ebook/productsEbook/category/'.$book_type->book_type) }}" style="border: 2px solid navy;" class="text-white hvr-grow m-1 p-1 btn btn-success init_color{{ $i++ }}"><h5>{{ $book_type->book_type }}</h5></a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 align-self-center" >
                        
                        <div class="my-2 text-left ">
                            <a href="{{ url('ebook/productsEbook') }}" class="product-menu hvr-grow mr-4">
                                <font size="3" color="black"><b>นิยาย E-Books มาใหม่</b></font>
                            </a> 

                            <!-- <a href="{{ url('products/bestSeller') }}" class="product-menu hvr-grow ml-4 mr-4">
                                <font size="3" color="black"><b>นิยาย E-Books ขายดี</b></font>
                            </a>  -->
                            <a href="{{ url('ebook/productsEbook/serie') }}" class="product-menu hvr-grow ml-4 mr-4">
                                <font size="3" color="black"><b>ซีรีส์ชุด E-Books</b></font>
                            </a> 
                            <!-- <a href="{{ url('products/buffet') }}" class="product-menu hvr-grow ml-4 mr-4">
                                <font size="3" color="black"><b>บุฟเฟ่ต์ Ebooks</b></font>
                            </a> -->
                            <div class="btn-group rounded">
                                <button type="button" class="btn btn-light border border-dark p-1 ">{{ $text_dropdown ?? 'ขายดีทั้งหมด' }}</button>
                                <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split p-1 " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="{{ url('ebook/productsEbook/') }}" >ขายดีทั้งหมด</a>
                                  <a class="dropdown-item" href="{{ url('ebook/productsEbook/ขายดีประจำวัน') }}" >ขายดีประจำวัน</a>
                                  <a class="dropdown-item" href="{{ url('ebook/productsEbook/ขายดีประจำสัปดาห์') }}" >ขายดีประจำสัปดาห์</a>
                                  <a class="dropdown-item" href="{{ url('ebook/productsEbook/ขายดีประจำเดือน') }}" >ขายดีประจำเดือน</a>
                                  <a class="dropdown-item" href="{{ url('ebook/productsEbook/ขายดีประจำปี') }}" >ขายดีประจำปี</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="option_head_text col-12 col-sm-12 col-md-6 col-lg-6 align-self-center">
                        <div class="form-inline my-2" style="float: right;">
                            <label>ค้นหา :  </label>
                            <input class="form-control" type="text" name="search_book" id="search_book" value="{{ $search ?? '' }}"> 
                            <a href="javascript:void(0)" id="btn_search" class="btn btn-light m-1"><i class="fas fa-search p-2 m-1"></i></a> 
                            <a href="javascript:void(0)" id="btn_filter" class="btn btn-light m-1"  data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-filter p-2 m-1"></i></a>                       
                        </div>                        
                    </div>   
                </div>
            </div>
        </div>
        <div class="container-fluid" >
            
                    <div class="row display-flex rcorners">
                        @foreach ($products_alls as $products_all)
                            <div class="product-item  product_img two    rcorners  col-12 col-xs-6 col-sm-6 col-md-6 col-lg-3 col-xl-2 center text-center">
                                <div class="card rcorners "  >
                                    <!-- <img class="" src=".../100px180/?text=Image cap" alt="Card image cap"> -->

                                    <div style=" max-width: 55vh;" class="rcorners card-img-top ">
                                        <figure class='book3d '>
                                          <!-- Front -->
                                          <ul class='hardcover_front '>
                                            <li style="background-color: #43202F; " class="pi-pic">
                                                @if($products_all->picture) 
                                                        <!--
                                                        <a href="public/storage/book-images/{{ $products_all->picture  }}" class="image-popup-no-margins  hvr-grow"  >
                                                            <img class="cropped1" style="background-color: HoneyDew;border: 2px solid DarkCyan;" src="{{ asset('storage/book-images/thumbnail/'.$products_all->picture) }}" >
                                                        </a> -->
                                                        <!-- pic_test -->
                                                        <img class="cropped1" src="{{ asset('storage/book-images/'.$products_all->picture) }}" >
                                                        <!-- <img class="cropped1" src="{{ asset('storage/book-images/'.$products_all->product_image) }}" > -->
                                                @else
                                                    <img class="cropped1" src="{{ asset('img/no_pic.png') }}" >                                
                                                @endif
         
                                                @auth
                                                <div class="icon_heart">
                                                    @if(empty($products_all->getFavorBook->id))
                                                    <a href="javascript:void(0)" data-id-product="{{ $products_all->id ?? '' }}" data-id-favor="{{ $products_all->getFavorBook->id ?? '' }}" data-type="ebook" class="add_mini_heart">
                                                    <i style="color: black;background-color: white;" class="far fa-heart fa-heart-book"></i></a>                                    
                                                    @else
                                                    <a href="javascript:void(0)" data-id-product="{{ $products_all->id ?? '' }}" data-id-favor="{{ $products_all->getFavorBook->id ?? '' }}" data-type="ebook" class="add_mini_heart">
                                                    <i style="color: red;background-color: white;" class="fas fa-heart fa-heart-book"></i></a>
                                                    @endif                                                                                        
                                                </div>
                                                @endauth
                                            </li>
                                            <li style="background-color: #43202F;"></li>
                                          </ul>
                                          <!-- Pages -->
                                          <ul class='page'>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                          </ul>
                                          <!-- Back -->
                                          <ul class='hardcover_back'>
                                            <li style="background-color: #43202F;"></li>
                                            <li style="background-color: #43202F;"></li>
                                          </ul>

                                        </figure>
                                        
                                      </div>
                                    
                                    <div class="card-body" >
                                        <div class="pi-text mt-1 text-left" >
                                            <a href="{{ url('ebook/productsEbook/detail/'.$products_all->id ?? '') }}"><font class="pl-4" size="4" color="black"><b>{{ $products_all->book_name ?? '-' }}</b></font></a>                                           
                                            <a href="{{ url('ebook/productsEbook/serie/'.$products_all->writer ?? '') }}" >
                                              <font class="pl-4" size="3" color="SlateGrey">{{ $products_all->writer ?? '-' }}<br></font> <!--ซีรีส์ชุด -->
                                            </a>           
                                        </div>
                                        
                                    </div>
                                    <div class="" style="width:100%;height: 70px;">
                                        <table  style="width:100%;height: 100%;">
                                            <tbody>
                                                <tr>                                                    
                                                    <td class="text-left pl-4">
                                                      @if(!empty($products_all->getApproveReadEbook->id))
                                                        <strong><font size="4"  color="red" class="" >ซื้อแล้ว</font></strong>
                                                      {{-- @elseif($products_all->tmp_cart_id)
                                                        <strong><font size="4"  color="red" class="" >อยู่ในตระกร้า</font></strong> --}}
                                                      @else
                                                        <b><font size="4"  color="red" class="" >฿{{number_format($products_all->product_price ?? '0')}}</font></b>                                                
                                                        <s><font size="4"  color="black" class="" >฿{{number_format($products_all->price ?? '0')}}</font></s>
                                                      @endif
                                                    </td>
                                                    <td class="text-right pr-4">
                                                        
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>  
                                    </div>

                                    <div class="caption rcorners " >   
                                        <table  style="width:100%;height: 100%;">
                                            <tbody>
                                                <tr>                                                    
                                                    <td>
                                                    @auth
                                                      <a href="javascript:void(0)" class="add_cart btn btn-danger p-2 rcorners2 hvr-grow shadow1 {{ $products_all->getApproveReadEbook ? 'disabled' : '' }}" data-has-product="{{ $products_all->getCartEbook->id ?? '' }}" style="width: 50px" data-id-product="{{ $products_all->id ?? '' }}" data-type="ebook" ><i class="fas fa-shopping-cart"></i></a>                                                                  
                                                    @else    
                                                        <a href="{{ route('login') }}" class="btn btn-danger p-2 rcorners2 hvr-grow shadow1" style="width: 50px"><i class="fas fa-shopping-cart"></i></a>    
                                                    @endauth
                                                        <a href="{{ url('file/'.$products_all->attachment) }}" class="btn btn-danger p-2 rcorners2 hvr-grow shadow1 {{ !$products_all->attachment ? 'disabled': '' }}" style="width: 50px" target=_blank  title="อ่านเรื่องย่อ"  ><i class="far fa-file-pdf"></i></a>                                                                            
                                                        <a href="{{ url('ebook/productsEbook/detail/'.$products_all->id) }}" class="btn btn-danger p-2 rcorners2 hvr-grow shadow1 " style="width: 50px"><i class="far fa-eye"></i></a>
                                                        <div style="display: inline;" class="link_image_popups">
                                                            <a href="{{ url('storage/book-images/'.$products_all->picture) }}" class="btn btn-danger p-2 image_popup_link rcorners2 hvr-grow shadow1" data-effect="mfp-zoom-out" style="width: 50px" ><i class="fas fa-expand-arrows-alt"></i></a>                                                      
                                                        </div>
                                                        
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>                                                                                                                                
                                                                                                                    
                                    </div>
                              
                                </div>                                 
                            </div>

                        @endforeach 
                    </div>



            {{-- <div class="row display-flex">
                @foreach ($products_alls as $products_all)
                    <div class="product-item    col-12 col-xs-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 center text-center">
                        <div class="card" >
                            <!-- <img class="" src=".../100px180/?text=Image cap" alt="Card image cap"> -->
                            <div class="card-header">
                                
                                <div class="pi-pic" 
                                    data-aos="fade-up"
                                    data-aos-anchor-placement="top-bottom">
                                    @if($products_all->picture)   
    
                                        <a href="{{ url('storage/book-images/'.$products_all->picture) }}" class="ajax-popup-link  hvr-grow" >
                                                <img class="cropped1 parent" style="background-color: HoneyDew;border: 2px solid DarkCyan;" src="{{ asset('storage/book-images/'.$products_all->picture) }}" >
                                        </a>
                                    @else
                                        <img class="cropped1" style="background-color: HoneyDew;border: 2px solid DarkCyan" src="{{ asset('img/no_pic.png') }}" >                                
                                    @endif
                                    @auth
                                    <div class="icon">
                                        @if($product_type !== "product_wait_fiction") 
                                            @if(empty($products_all->favor_book_id))
                                            <a href="javascript:void(0)" data-id-product="{{ $products_all->id_product }}" data-id-favor="{{ $products_all->favor_book_id }}"  class="add_mini_heart">
                                            <i style="color: HotPink;-webkit-text-stroke-width: 1px;
                                -webkit-text-stroke-color: HotPink;" class="far fa-heart"></i></a>                                    
                                            @else
                                            <a href="javascript:void(0)" data-id-product="{{ $products_all->id_product }}" data-id-favor="{{ $products_all->favor_book_id }}" class="add_mini_heart">
                                            <i style="-webkit-text-fill-color: LightPink;
                                -webkit-text-stroke-width: 3px;
                                -webkit-text-stroke-color: HotPink; " class="fas fa-heart"></i></a>
                                            @endif
                                        @endif
                                    </div>
                                    @endauth
                                    <ul>
                                        @auth
                                        @if($product_type !== "product_wait_fiction")
                                            <li class="w-icon active hvr-grow">
                                                <a href="javascript:void(0)" data-id-product="{{ $products_all->id_product }}" class="add_cart"><i class="fas fa-cart-plus fa-1x"></i></a>
                                            </li>
                                        @endif
                                        @else
                                        <li class="w-icon active hvr-grow">  
                                            <a href="{{ route('login') }}" class=""><i class="fas fa-cart-plus fa-1x"></i></a>
                                        </li>
                                        @endauth
                                        @if($product_type !== "product_wait_fiction" && $product_type !== "product_blame")
                                        <li class="quick-view hvr-grow"><a href="{{ url('ebook/productsEbook/detail').'/'.$products_all->id_product }}">+ View</a></li>                                  
                                        @endif
                                        @if($products_all->picture) 
                                                <!-- <li class="w-icon hvr-grow"><a href="/public/storage/book-images/{{ $products_all->picture  }}" target="_blank" title="ดูรูปปก"><i class="fas fa-search-plus"></i></a></li> -->
                                                <!-- pic_test -->
                                                <li class="w-icon hvr-grow"><a href="{{ url('storage/book-images/'.$products_all->picture) }}" target="_blank" title="ดูรูปปก"><i class="fas fa-search-plus"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body" style="background-color:White;border: 1px solid WhiteSmoke;">

                                <div class="pi-text mt-1 text-left" >
                                    @if($product_type !== "product_wait_fiction" && $product_type !== "product_blame")
                                        @if($products_all->product_name)
                                            <a href="{{ url('ebook/productsEbook/detail').'/'.$products_all->id_product }}"><font class="pl-2" size="4"  color="#ff4bc6">{{ $products_all->product_name }}</font></a>
                                        @endif
                                    @endif                  
                                    @if($products_all->serie_set)
                                        <a href="{{ url('ebook/productsEbook/serie/'.$products_all->serie_set) }}" >
                                            <font class="pl-2" size="3" color="#824300">
                                                <!-- <b>ซีรีส์ชุด : </b> -->
                                                {{ $products_all->serie_set }}<br>
                                            </font>
                                        </a>  
                                    @else
                                    <font class="pl-2" size="3" color="#824300">
                                        <!-- <b>ซีรีส์ชุด : </b> -->
                                        -<br>
                                    </font>
                                    @endif
                                    <br>       
                                </div>
                            </div>
                            <div class="card-footer">
                                
                                <div class="pi-text " >
                                    
                                    <div class="wrap_btn_book_list">
                                        <table class="table_btn_book_list" style="width:100%;">
                                        <tbody>
                                            <tr style="width:100%;">
                                                @if(!empty($products_all->product_pdf2))  
                                                
                                                <td >
                                                <div>
                                                    @if($products_all->product_pdf2)  
                                                    &nbsp;<a style="display: inline;" href="file/{{ $products_all->product_pdf2 }}" target=_blank  title="อ่านเรื่องย่อ"><img src="{{ asset('images/pdf_icon.png') }}" border=0 height=20></a>
                                                    @endif
                                                </div>
                                                </td>
                                                @endif

                                                @if($product_type !== "product_wait_fiction")   
                                                <td valign="middle"  class="" width="60%" height="100%"  align="center" >
                                                     @if($products_all->product_price)
                                                    <!-- <b>ราคา : </b>
                                                    -->
                                                    <a href="javascript:void(0)" data-id-product="{{ $products_all->id_product }}" class="btn btn-outline-success add_cart "  > 
                                                        <b><font size="5" style="text-decoration: underline;" color="red" class="price-sale ">{{number_format($products_all->product_price)}}</font></b><br>
                                                        <font class="price " >
                                                            <del>
                                                            <span class="amount">{{ $products_all->price }}</span>
                                                            </del>
                                                        </font>
                                                        <b><font color="#006400" class="">   บาท</font></b>
                                                    </a>
                                                    
                                                    @else
                                                    <a href="javascript:void(0)"  class="btn btn-outline-success "  ><b><font size="5" color="red">-</font> บาท</b></a>
                                                    @endif
                                                </td> 
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>

                            </div>
                        </div>               
                    </div>
                @endforeach 
            </div> --}}


            <hr>
            <center><font size="4" color="black" >ทั้งหมด <span class="style4"><b>{{ $products_alls->total() }}</b></span> รายการ <b></font></center>
            <br>
            {{ $products_alls->links() }} 
        </div>
    </section>
    <!-- Women Banner Section End -->

    
@endsection

@section('js')


<script>
    $(function(){
        $('.select2').select2();
        for(i2 = 0 ; i2<= {{ $i }} ; i2++){
            // -0.2)  //- 20% lighter
            // -0.5 //- 50% darker
            $(".init_color"+i2).css("background-color",ColorLuminance(getRandomColor(), -0.2));
        }
        // Image popups
        $('.link_image_popups').magnificPopup({
            delegate: 'a',
            type: 'image',
            removalDelay: 500, //delay removal by X to allow out-animation
            callbacks: {
                beforeOpen: function() {
                // just a hack that adds mfp-anim class to markup 
                this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                this.st.mainClass = this.st.el.attr('data-effect');
                }
            },
            closeOnContentClick: true,
            midClick: true 
        });
       
        
        $('body').on('click', '.add_cart', function() {
            var Item_id = $(this).data('id-product');
            var blame_product = $(this).data('blame-product');
            var buffet = $(this).data('buffet');
            var can_discount = $(this).data('can-discount');
            var type = $(this).data('type') ?? '' ;

            var has_product = $(this).attr('data-has-product');
            
            if(has_product){ // has a producet in cart
              // alert("123")
              mini_cart('delete_mini',Item_id ,type).then(  
                Swal.fire({
                  position: 'top-end',
                  icon: 'error',
                  title: 'ลบสินค้าออกจากตะกร้าเรียบร้อยแล้วค่ะ',
                  showConfirmButton: false,
                  timer: 1000,
                }).then((result) => {
                    // mini_cart('show','','ebook');  
                    location.reload()
                    
                })
              );
              
            }else{
            
                var user_id = "{{ $user ? $user->id : '' }}" ;
                var username = "{{ $user ? $user->username : '' }}";
                // var user_id = "{{ !empty($user->id) ? $user->id : null  }}" ;
                // var username = "{{ !empty($user->username) ? $user->username : null }}";
                
                //alert(Item_id);
                $.ajax({
                    type: "POST",
                    url: "{{ url('cart') }}",
                    data:{_token: "{{ csrf_token() }}", product_id:Item_id , user_id: user_id ,
                    username: username , blame_product: blame_product , buffet: buffet, can_discount:can_discount,type:type },
                    success: (response) => {    
                        if ($.isEmptyObject(response.error)) {
                                //console.log(response)
                                console.log(response.success);
                                Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'เพิ่มสินค้าลงตะกร้าเรียบร้อยแล้วค่ะ',
                                showConfirmButton: false,
                                timer: 1000,
                                }).then((result) => {
                                    mini_cart('show','','ebook');  
                                    location.reload()
                                });
                        } else {
                            console.log(response.error);
                            Swal.fire({
                                icon: 'warning',
                                title: "เตือน",
                                text: "" + response.error,
                            });
                        }
                    },
                    error: (response) => {
                        console.log('Error:', response);
                        Swal.fire({
                            icon: 'error',
                            title: "<strong>Error edit record.</strong>",
                            html: "<strong>Error Code: </strong>" + response.status +
                                "<p><strong>Message: </strong>" + JSON.stringify(response
                                    .responseJSON.message) + "</p>",
                        });
                    }
                });
            }
        });
        $("#search_book").on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                window.location.href = "{{ url('ebook/productsEbook') }}/"+$('#search_book').val();
            }
        });
        $('body').on('click', '#btn_search', function() {
            window.location.href = "{{ url('ebook/productsEbook') }}/"+$('#search_book').val();
        });
        $('body').on('click', '.add_mini_heart', function() {
            
            Item_id = $(this).data('id-product');
            var favor = $(this).data('id-favor') ?? '' ;
            var type = $(this).data('type') ?? '' ;
            
            if(favor){
                var status = 'delete_mini_heart';
            }else{
                var status = 'add_mini_heart';
            }
            // alert(type)
            // alert(status)
    
            mini_heart(status,Item_id,type).then(
                Swal.fire({
                    icon: 'success',
                    title: 'เพิ่มหนังสือโปรดของคุณเรียบร้อยแล้วค่ะ',
                    showConfirmButton: false,
                    timer: 2000,                          
                }).then(
                    location.reload()
                )
            )
        });
    });
function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}
function ColorLuminance(hex, lum) {
  // validate hex string
  hex = String(hex).replace(/[^0-9a-f]/gi, '');
  if (hex.length < 6) {
    hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
  }
  lum = lum || 0;

  // convert to decimal and change luminosity
  var rgb = "#", c, i;
  for (i = 0; i < 3; i++) {
    c = parseInt(hex.substr(i*2,2), 16);
    c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
    rgb += ("00"+c).substr(c.length);
  }

  return rgb;
}
</script>
@endsection