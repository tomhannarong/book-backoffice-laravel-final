@extends('../layouts.front-ebook')

@section('menu_home_ebook' , 'active_nav')

@section('css')
<style>
.center {
    justify-content: center;
}
.linear-5 {
    background: rgb(255,252,220);
    background: radial-gradient(circle, rgba(255,252,220,1) 0%, rgba(255,113,151,1) 50%, rgba(255,194,145,1) 100%);
}
.linear-6 {
    background: rgb(131,241,0);
    background: radial-gradient(circle, rgba(131,241,0,1) 0%, rgba(220,255,195,1) 100%);
}
.linear-7 {
    background: rgb(255,188,111);
    background: radial-gradient(circle, rgba(255,188,111,1) 0%, rgba(241,255,143,1) 100%);
}


.swiper-container {
	width: 100%;
    height: 100%;
    -webkit-tap-highlight-color: transparent;
    
}
.swiper-slide {
	text-align: center;
	font-size: 18px;
	/* background: #fff; */
	/* Center slide text vertically */
	display: -webkit-box;
	display: -ms-flexbox;
	display: -webkit-flex;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	-webkit-justify-content: center;
	justify-content: center;
	-webkit-box-align: center;
	-ms-flex-align: center;
	-webkit-align-items: center;
    align-items: center;
    height: auto;
}
/* .swiper-pagination {
	position: absolute;
	top: 10px;
	right: 10px;
	width: auto !important;
	left: auto !important;
	margin: 0;
}
.swiper-pagination-bullet {
    padding: 5px 5px;
	border-radius: 0;
	width: auto;
	height: 30px;
	text-align: center;
	line-height: 30px;
	font-size: 12px;
	color:#000;
	opacity: 1;
	background: rgba(0,0,0,0.2);
}
.swiper-pagination-bullet-active {
	color:#fff;
	background: #007aff;
} */
.swiper-pagination-bullets {
  bottom: 10px;
  left: 0;
  width: 100%;
}
.swiper-pagination-bullets .swiper-pagination-bullet {
  margin: 8px 4px 10px 10px;
}
@media screen and (max-width: 768px) {
 .swiper-pagination-bullets .swiper-pagination-bullet {
    margin: 0 5px;
  }
}

.swiper-pagination-bullet {
  width: 11px;
  height: 11px;
  /* display: block; */
  border-radius: 10px;
  background: red;
  /* background: #062744; */
  opacity: 0.2;
  transition: all 0.3s;
}
.swiper-pagination-bullet-active {
  opacity: 1;
  background: #fd3838;
  /* height: 30px; */
  width: 30px;
  box-shadow: 0px 0px 20px rgba(252, 56, 56, 0.3);
}


.head_text {
    border-bottom: 1px solid #8e918f;
    padding-bottom: 5px;
    /* margin-bottom: 20px; */
    position: relative;
}
.option_head_text {
    align-items: center;
    position: absolute;
    right: 0;
    bottom: 7px;
    /* font-family: Helvetica,Thonburi,Tahoma,sans-serif; */
    font-size: 20px;
    color: red;
}
.option_head_text a {
    color: black;
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

.box {
  /* width: 200px;  */
  width: 100%; 
  /* height: 300px; */
  position: relative;
  border: 1px solid #BBB;
  background: #EEE;
}
.ribbon2 {
  position: absolute;
  /* right: -5px; top: -5px; */
  right: -5px; top: -5px;
  z-index: 1;
  overflow: hidden;
  width: 150px; height: 150px;
  text-align: right;
}
.ribbon2 span {
  font-size: 18px;
  font-weight: bold;
  color: #FFF;
  text-transform: uppercase;
  text-align: center;
  line-height: 20px;
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
  width: 200px;
  display: block;
  background: #79A70A;
  background: linear-gradient(#9BC90D 0%, #79A70A 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
  position: absolute;
  top: 23px; right: -45px;
  /* top: 2px; right: -50px; */
}
.ribbon2 span::before {
  content: "";
  position: absolute; left: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid #79A70A;
  border-right: 3px solid transparent;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #79A70A;
}
.ribbon2 span::after {
  content: "";
  position: absolute; right: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid transparent;
  border-right: 3px solid #79A70A;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #79A70A;
}
/* .card { 
    border: 0;
} */
.card-header {
    padding: 0;
}
.card-body {
    padding: 0;
    padding-top: 70%;
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



/* .swiper-container {
	-webkit-tap-highlight-color: transparent;
}

.swiper-slide {
	height: auto;
} */

.m-slider {
	overflow: hidden;
	margin: 0 auto;
	padding: 30px;
    padding-top: 100px;
    /* background-color: #eee; */
    background-color: white;
	box-shadow: inset 0 0 6px rgba(0, 0, 0, .1);

	.m-slider__item {
		display: flex;
		flex: 0 0 auto;
		width: 100%;
	}
}

.m-card {
	display: flex;
	flex-direction: column;
	/* padding: 30px; */
	width: 100%;
	border-radius: 3px;
	background-color: #fff;
	box-shadow: 0 0 6px rgba(0, 0, 0, .1);
	transition-duration: .3s;
	transition-property: box-shadow;

	.m-card__header {
		padding-top: 75%;
		height: 0;
		background-position: center;
		background-size: cover;
	}

	.m-card__body {
        margin-top: 15px;
        background-color: #fff;
	}

	&:active {
		box-shadow: 0 0 0 rgba(0, 0, 0, 0);
	}
}

.slider {
	margin: 0 -30px;
}

.cards {
	margin-top: 30px;

	.cards__note {
		margin-top: 30px;
	}

	.cards__body {
		margin-top: 30px;

		@media screen and (min-width: 768px) {
			display: flex;
		}
	}

	.cards__item {
		display: flex;
		flex: 0 1 auto;
		margin-top: 30px;
		width: 100%;

		@media screen and (min-width: 768px) {
			margin-top: 0;
		}
	}

	.cards__item:not(:last-of-type) {
		@media screen and (min-width: 768px) {
			margin-right: 30px;
		}
	}
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
/* .card-img-top-best {
    position: absolute;
  top: 65%;
  left: 10%;
  flex-shrink: 0;
    width: 80%;
} */
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








 main {
	 flex-grow: 1;
	 display: flex;
	 align-items: center;
	 justify-content: center;
}
 .book-card {
	 width: 280px;
	 padding: 16px;
	 border-radius: 5px;
	 background-color: #fff;
     box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
     
}
 .book-card .book-card__cover {
	 position: relative;
	 width: 200px;
	 height: 300px;
	 margin: 0 auto 8px auto;
	 perspective: 1000px;
}
 .book-card .book-card__book {
	 height: 100%;
	 transform-style: preserve-3d;
     transition: all 250ms ease;
     box-shadow: 0 8px 16px 5px rgba(0,0,0,0.2);
}
 .book-card .book-card__book-front {
	 position: absolute;
	 height: 100%;
}
 .book-card .book-card__book-back {
	 position: absolute;
	 top: 0;
	 height: 100%;
	 width: 100%;
	 transform: translateZ(-40px);
}
 .book-card .book-card__book-side {
	 position: absolute;
	 top: 5px;
	 bottom: 2px;
	 right: -29px;
	 width: 40px;
	 background-size: 5px;
	 background-color: #e1e1e1;
	 background-image: linear-gradient(to right, #ccc 35%, #e1e1e1 35%);
	 opacity: 0;
	 transform: rotate3d(0, 1, 0, 90deg);
}
 .book-card .book-card__img {
	 width: 100%;
	 height: 100%;
	 background-color: #e1e1e1;
}
 .book-card .book-card__title {
	 font-size: 1.5em;
	 margin-bottom: 8px;
}
 .book-card .book-card__author {
	 color: #757575;
	 font-size: 1em;
}
 .book-card:hover .book-card__book {
	 transform: rotate3d(0, -1, 0, 30deg) translate(-15px, -30px);
}
 .book-card:hover .book-card__book-back {
	 box-shadow: 5px 10px 15px rgba(0, 0, 0, 0.35);
}
 .book-card:hover .book-card__book-side {
	 opacity: 1;
}
 






.monitor .front {
  height: 8em;
  width: 10em;
  background: #e0e0e0;
  -webkit-transform: translateZ(4em);
  -moz-transform: translateZ(4em);
  -ms-transform: translateZ(4em);
  -o-transform: translateZ(4em);
  transform: translateZ(4em);
}



.stage {
  width: 100%;
  height: 700px;
  position: relative;
  -webkit-perspective: 1600px;
  -moz-perspective: 1600px;
  -ms-perspective: 1600px;
  -o-perspective: 1600px;
  perspective: 1600px;
  -webkit-perspective-origin: 50% 100px;
  -moz-perspective-origin: 50% 100px;
  -ms-perspective-origin: 50% 100px;
  -o-perspective-origin: 50% 100px;
  perspective-origin: 50% 100px;
  
}

.positioning {
  position: absolute;
  width: 9em;
  top: 3em;
  left: 50%;
  margin-left: -4.5em;
  -webkit-transform-style: preserve-3d;
  -moz-transform-style: preserve-3d;
  -ms-transform-style: preserve-3d;
  -o-transform-style: preserve-3d;
  transform-style: preserve-3d;
  -webkit-transform: rotateY(-40deg);
  -moz-transform: rotateY(-40deg);
  -ms-transform: rotateY(-40deg);
  -o-transform: rotateY(-40deg);
  transform: rotateY(-40deg);
}





.book-container {
  /* width: 100%; */
  height: 300px;
  margin: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  perspective: 400px;
}

.book {
  /* transform: rotateY(-30deg); */
  position: relative;
  transform-style: preserve-3d;
  /* width: 200px;
  height: 300px; */
  transition: transform 1s ease;
  animation: 1s ease 0s 1 initAnimation;
}

/* .book:hover {
  transform: rotate(0deg);
} */

/* @keyframes initAnimation {
  0% {
    transform: rotateY(0deg);
  }
  100% {
    transform: rotateY(-30deg);
  }
} */

/* .book > :first-child {
  position: absolute;
  background: #0d47a1aa;
  width: 200px;
  height: 300px;
  border-top-right-radius: 3px;
  border-bottom-right-radius: 3px;
  box-shadow: 5px 5px 20px #666;
}

.book::before {
  content: ' ';
  background: #fff;
  height: calc(300px - 2 * 3px);
  width: 50px;
  top: 3px;
  position: absolute;
  transform: translateX(calc(200px - 50px / 2 - 3px)) rotateY(90deg) translateX(calc(50px / 2))

}

.book::after {
  content: ' ';
  position: absolute;
  left: 0;
  width: 200px;
  height: 300px;
  border-top-right-radius: 3px;
  border-bottom-right-radius: 3px;
  background: #01060f;
  transform: translateZ(-50px);
  box-shadow: -10px 0 50px 10px #666;
} */








.blog-slider {
  /* width: 95%; */
  position: relative;
  max-width: 800px;
  margin: auto;
  /* background: #fff; */
  box-shadow: 0px 14px 80px rgba(34, 35, 58, 0.2);
  padding: 25px;
  border-radius: 25px;
  /* height: 400px; */
  /* height: 100%; */
  transition: all 0.3s;
}
@media screen and (max-width: 992px) {
  .blog-slider {
    /* max-width: 680px; */
    /* height: 400px; */
  }
}
@media screen and (max-width: 768px) {
  .blog-slider {
    /* min-height: 500px;
    height: auto; */
    /* margin: 180px auto; */
  }
}
@media screen and (max-height: 500px) and (min-width: 992px) {
  .blog-slider {
    /* height: 350px; */
  }
}
.blog-slider__item {
  display: flex;
  align-items: center;
}
@media screen and (max-width: 768px) {
  .blog-slider__item {
    /* flex-direction: column; */
  }
}
.blog-slider__item.swiper-slide-active .blog-slider__img img {
  opacity: 1;
  transition-delay: 0.3s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > * {
  opacity: 1;
  transform: none;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(1) {
  transition-delay: 0.3s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(2) {
  transition-delay: 0.4s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(3) {
  transition-delay: 0.5s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(4) {
  transition-delay: 0.6s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(5) {
  transition-delay: 0.7s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(6) {
  transition-delay: 0.8s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(7) {
  transition-delay: 0.9s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(8) {
  transition-delay: 1s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(9) {
  transition-delay: 1.1s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(10) {
  transition-delay: 1.2s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(11) {
  transition-delay: 1.3s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(12) {
  transition-delay: 1.4s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(13) {
  transition-delay: 1.5s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(14) {
  transition-delay: 1.6s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(15) {
  transition-delay: 1.7s;
}
 .blog-slider__img {
     width: 90%;
	 /* width: 300px; */
	 flex-shrink: 0;
	 height: 300px;
	 background-image: linear-gradient(147deg, #fe8a39 0%, #fd3838 74%);
	 box-shadow: 4px 13px 30px 1px rgba(252, 56, 56, 0.2);
     border-radius: 20px;
     margin-top:5px;
	 /* transform: translateX(-80px); */
	 /* overflow: hidden; */
}


 .blog-slider__img:after {
	 content: '';
	 position: absolute;
	 top: 0;
	 left: 0;
	 width: 100%;
	 height: 100%;
	 /* background-image: linear-gradient(147deg, #fe8a39 0%, #fd3838 74%); */
	 border-radius: 20px;
	 opacity: 0.8;
}
.blog-slider__img:after {
  /* content: "";
  position: absolute;
  top: 0;
  left: 0; */
  /* width: 100%;
  height: 100%; */
  /* background-image: linear-gradient(147deg, #fe8a39 0%, #fd3838 74%); */
  /* border-radius: 20px; */
  /* opacity: ; */
}
 .blog-slider__img img {
	 width: 100%;
	 height: 100%;
	 object-fit: cover;
	 display: block;
	 opacity: 0;
	 border-radius: 20px;
	 transition: all 0.3s;
}
.blog-slider__img img {
  /* width: 100%;
  height: 100%; */
  /* object-fit: cover; */
  /* display: block; */
  /* opacity: 0;
  border-radius: 20px;
  transition: all 0.3s; */
}

@media screen and (max-width: 1000px) {
  .blog-slider__img {
    width: auto;
  }
}
@media screen and (max-width: 768px) {
  .blog-slider__img {
    /* transform: translateY(-50%); */
    width: 90%;
  }
}
@media screen and (max-width: 576px) {
  .blog-slider__img {
    width: 50%;
  }
}
@media screen and (max-height: 500px) and (min-width: 992px) {
  .blog-slider__img {
    /* height: 270px; */
  }
}
.blog-slider__content {
  padding-right: 25px;
}
@media screen and (max-width: 768px) {
  .blog-slider__content {
    /* margin-top: -80px; */
    text-align: center;
    padding: 0 30px;
  }
}
@media screen and (max-width: 576px) {
  .blog-slider__content {
    padding: 0;
  }
}
.blog-slider__content > * {
  opacity: 0;
  transform: translateX(90px);
  transition: all 0.4s;
}
.blog-slider__code {
  /* color: #7b7992; */
  color: #000;
  margin-bottom: 15px;
  display: block;
  font-weight: 500;
}
.blog-slider__title {
  font-size: 24px;
  font-weight: 700;
  color: #0d0925;
  /* margin-bottom: 20px; */
  margin-bottom: 5px;
}
.blog-slider__text {
  color: #4e4a67;
  margin-bottom: 30px;
  line-height: 1.5em;
}
.blog-slider__button {
  display: inline-flex;
  /* background-image: linear-gradient(147deg, #fe8a39 0%, #fd3838 74%); */
  background-color: white;
  
  padding: 15px 35px;
  /* border-radius: 50px; */
  border-radius: 10px;
  border: 1px solid orangered; 
  /* color: #fff; */
  color: orangered;
  /* box-shadow: 0px 14px 80px rgba(252, 56, 56, 0.4); */
  text-decoration: none;
  font-weight: 500;
  justify-content: center;
  text-align: center;
  letter-spacing: 1px;
}
@media screen and (max-width: 576px) {
  .blog-slider__button {
    width: 100%;
  }
}
.blog-slider .swiper-container-horizontal > .swiper-pagination-bullets, .blog-slider .swiper-pagination-custom, .blog-slider .swiper-pagination-fraction {
  bottom: 10px;
  left: 0;
  width: 100%;
}
.blog-slider__pagination {
  /* position: absolute; */
  z-index: 21;
  right: 20px;
  /* width: 11px !important; */
  text-align: center;
  left: auto !important;
  top: 50%;
  bottom: auto !important;
  transform: translateY(-50%);
}
@media screen and (max-width: 768px) {
  .blog-slider__pagination {
    /* transform: translateX(-50%); */
    left: 50% !important;
    top: 205px;
    width: 100% !important;
    display: flex;
    justify-content: center;
    align-items: center;
  }
}
.blog-slider__pagination.swiper-pagination-bullets .swiper-pagination-bullet {
  margin: 8px 4px 10px 10px;
}
@media screen and (max-width: 768px) {
  .blog-slider__pagination.swiper-pagination-bullets .swiper-pagination-bullet {
    margin: 0 5px;
  }
}

.blog-slider__pagination .swiper-pagination-bullet {
  width: 11px;
  height: 11px;
  /* display: block; */
  border-radius: 10px;
  background: #062744;
  opacity: 0.2;
  transition: all 0.3s;
}
.blog-slider__pagination .swiper-pagination-bullet-active {
  opacity: 1;
  background: #fd3838;
  /* height: 30px; */
  width: 30px;
  box-shadow: 0px 0px 20px rgba(252, 56, 56, 0.3);
}
@media screen and (max-width: 768px) {
  .blog-slider__pagination .swiper-pagination-bullet-active {
    height: 11px;
    width: 30px;
  }
}










.owl-item > div {
  cursor: pointer;
  margin: 22% 25%;
  margin-bottom: 0;
  transition: margin 0.6s linear ;
}
.owl-item.center > div {
  cursor: auto;
  /* margin-top: 10%; */
  margin-left: 20%;
  margin-right: 20%;
  margin-top: 0;
  margin-bottom: 0;
}
.owl-item:not(.center) > div:hover {
  opacity: .75;
}
/* .owl-carousel .owl-stage-outer {
    padding-top:15px;
    padding-bottom:15%;
} */
.owl-carousel .owl-item img {
    height:auto;
    width:100%;
    display: block;
}

.owl-carousel .item {
    margin:0px;

    /* box-shadow:
    0 2.8px 2.2px rgba(0, 0, 0, 0.034),
  0 6.7px 5.3px rgba(0, 0, 0, 0.048),
  0 12.5px 10px rgba(0, 0, 0, 0.06),
  0 22.3px 17.9px rgba(0, 0, 0, 0.072),
  0 41.8px 33.4px rgba(0, 0, 0, 0.086),
  0 100px 800px rgba(0, 0, 0, 0.12); */

 

    /* margin-left: 20px;
    margin-right: 20px;
    margin-top: 20px; */
    /* padding: 50px; */
    /* padding-left: 25px;
    padding-right: 25px;
    padding-top: 25px; */
    /* padding-bottom: 50px; */
    
}





.main-content {
  position: relative;
}
.main-content .owl-theme .custom-nav {
  position: absolute;
  top: 20%;
  left: 0;
  right: 0;
}
.main-content .owl-theme .custom-nav .owl-prev, .main-content .owl-theme .custom-nav .owl-next {
  position: absolute;
  height: 100px;
  color: inherit;
  background: none;
  border: none;
  /* z-index: 100; */
}
.main-content .owl-theme .custom-nav .owl-prev i, .main-content .owl-theme .custom-nav .owl-next i {
  font-size: 2.5rem;
  color: #cecece;
}
.main-content .owl-theme .custom-nav .owl-prev {
  left: 0;
}
.main-content .owl-theme .custom-nav .owl-next {
  right: 0;
}


/* .owl-carousel .owl-item img {
    display: block;
    width: 150px;
} */
.owl-carousel {
    display: none;
    width: 100%;
    z-index: auto;
}







.shape {
  /* width: 130px;
  height: 300px; */
/*   margin: 30px; */
/*   float: left; */
/*   -webkit-perspective: 10px; */
/*   -moz-perspective: -1000px; */
  perspective: 1000px;

} 

.book::after {
  content: '';
  width: 100px;
  height: 100%;
  position: absolute;
  bottom: 0;
  box-shadow: 80px -250px 120px 50px rgba(0,55,55,0.9);
    transform: rotateX(90deg) translateY(50px);
  transform-origin: 100% 100%;
  perspective: 500px;

}
.frame {
	 /* position: absolute; */
	 /* left: 50%; */
	 /* margin-left: -112px; */
	 /* top: 50%; */
	 /* margin-top: -150px; */
	 /* border-top: 25px solid #784320; */
	 /* border-right: 25px solid #6a3919; */
	 /* border-bottom: 25px solid #945a33; */
	 border-left: 10px solid #8f4b1e;
     border-radius: 5px;
	 /* width: 200px;
	 height: 300px; */
}
 
.vr{
  display: inline-block; vertical-align: middle;
  height: 30px;
  margin-left: 5px;
  margin-right: 5px;
  width: 1px;
  background-color: white;
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
 





.tab_book {
    margin: 0;
    padding: 0;
    /* background: DarkRed; */
    color: white;
    margin: 10px 0 0 10px;
    padding: 5px 15px 5px 15px;
    position: absolute;
    top: 0;
    border-radius: 10px;
    /* right: 0; */
    /* transform: translateX(30%) translateY(0%) rotate(45deg); */
    transform-origin: top left;
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



.cropped {
    width: 100%;
    height: 400px;
    object-fit: cover;
    /* border: 5px solid black; */
}
.swiper-container {
    z-index: 0;
}



/* .swiper-button-next,
.swiper-button-prev {
    background-color: white;
    background-color: rgba(255, 255, 255, 0.5);
    right:10px;
    padding: 30px;
    color: #000 !important;
    fill: black !important;
    stroke: black !important;
} */
.swiper-button-next {
  background-image: url({{url('images/bg/button_next.png')}});
  padding: 25px;
  background-repeat: no-repeat;
  background-size: 100% auto;
  background-position: center;
}
.swiper-button-prev {
  background-image: url({{url('images/bg/button_back.png')}});
  padding: 25px;
  background-repeat: no-repeat;
  background-size: 100% auto;
  background-position: center;
}

.swiper-button-next::after {
  display: none;
}
.swiper-button-prev::after {
  display: none;
}







</style>


    
@endsection

@section('content')

    <section class="py-1">
        <!-- Slider main container -->
        <div class="swiper_slide swiper-container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                @foreach ($slides as $slide) 
                {{-- cropped --}}
                <div class="swiper-slide"><img width="100%" height="400px" class="cropped" src="{{ asset('storage/slide-images/'.$slide->slide_images) }}" ></div>
                @endforeach
                
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination "></div>
            
            
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>








<section class="bg-light" style="background-image: url({{url('images/bg/bg_top_10_2.png')}}) ;background-size: 100% 100%;">
        <div class="container " >
            <div class="head_text" style="padding-top:20px;margin-bottom: 20px;">
                {{-- <h2 class="">10 อันดับ E-Books ขายดี </h2> //btn-light border-0 border-dark p-1 --}}
                <div>
                  <div class="btn-group roundedhead_text_string ">
                    <button type="button" class="btn border-0 border-dark p-1 "><h2>{{ $text_dropdown ?? 'E-Books ขายดีประจำเดือน' }}</h2></button>
                    <button type="button" class="btn btn-dark dropdown-toggle rounded dropdown-toggle-split p-1 " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ url('ebook') }}" >ขายดีทั้งหมด</a>
                      <a class="dropdown-item" href="{{ url('ebook/ขายดีประจำวัน') }}" >ขายดีประจำวัน</a>
                      <a class="dropdown-item" href="{{ url('ebook/ขายดีประจำสัปดาห์') }}" >ขายดีประจำสัปดาห์</a>
                      <a class="dropdown-item" href="{{ url('ebook/ขายดีประจำเดือน') }}" >ขายดีประจำเดือน</a>
                      <a class="dropdown-item" href="{{ url('ebook/ขายดีประจำปี') }}" >ขายดีประจำปี</a>
                    </div>
                  </div>
                </div>
                <div class="option_head_text">
                    <a href="{{ url('ebook/productsEbook/'.$search ?? '' ) }}" class="btn btn-outline-danger p-2 pl-3 pr-3" style="float: right;"><font size="3" color="">ดูทั้งหมด</font></a>
                </div>
            </div>
            
            <div class="main-content" >
                <div class="owl-carousel owl-theme">

                    @foreach ($best_sellers as $best_seller)
                    <div class=" shape" data-name="{{ $best_seller->getProduct->book_name ?? '' }}" data-serie_set ="{{ $best_seller->getProduct->writer ?? '' }}"
                        data-alias_price="{{ $best_seller->getProduct->price ?? '' }}" data-product_price="{{ $best_seller->getProduct->product_price ?? '' }}" data-id-product="{{ $best_seller->getProduct->id ?? '' }}" 
                        data-approve_id="{{ $best_seller->getApproveReadEbook->id ?? '' }}" data-has_product="{{ !empty($best_seller->getCartEbook->id) ?? '' }}" >
                        @if(!empty($best_seller->getProduct->picture)) 
                        <div class="item book" style="">
                                
                                <img class="frame parent"  src="{{ asset('storage/book-images/'.$best_seller->getProduct->picture) }}" >
                                
                                @auth
                                    <div class="icon_heart">
                                        @if(empty($best_seller->getFavorBook->id))
                                        <a href="javascript:void(0)" data-id-product="{{ $best_seller->getProduct->id ?? '' }}" data-id-favor="{{ $best_seller->getFavorBook->id ?? '' }}" data-type="ebook"  class="add_mini_heart">
                                        <i style="color: black;background-color: white;" class="far fa-heart fa-heart-book"></i></a>                                    
                                        @else
                                        <a href="javascript:void(0)" data-id-product="{{ $best_seller->getProduct->id ?? ''}}" data-id-favor="{{ $best_seller->getFavorBook->favor_book_id ?? '' }}" data-type="ebook" class="add_mini_heart">
                                        <i style="color: red;background-color: white;" class="fas fa-heart fa-heart-book"></i></a>
                                        @endif
                                    </div>
                                @endauth        
                                                
                        </div>
                            @else
                                <img  src="{{ asset('img/no_pic.png') }}" >                                
                            @endif
                    </div>

                    @endforeach 
                  
                </div>
                <div class="owl-theme">
                    <div class="owl-controls">
                        <div class="custom-nav owl-nav"></div>
                    </div>
                </div>
                <div class="text-center card-img-top-best" class="">
                    <p class="">
                      <font id="parent_price" style="border: solid 1px red;" class="p-2 mb-4 rcorners2 bg-white">
                        @if(!empty($best_sellers[0]->getApproveReadEbook->_id))
                          <strong><font size="4"  color="red" class="" >ซื้อแล้ว</font></strong>
                        {{-- @elseif($products_new->tmp_cart_id)
                          <strong><font size="4"  color="red" class="" >อยู่ในตระกร้า</font></strong> --}}
                        @else
                          <strong><font id="best_product_price"  style="color:red;" >฿{{ $best_sellers[0]->getProduct->product_price ?? '-' }}</font></strong>
                          <s><font id="best_alias_price" >฿{{ $best_sellers[0]->getProduct->price ?? '-' }}</font></s>
                        @endif
                      </font> 
                      
                    </p>

                    <a id="best_name_url" href="{{ url('ebook/productsEbook/detail/'.($best_sellers[0]->getProduct->id ?? '') ) }} " ><h5  class="mb-2"><b><font id="best_name" size="4" color="red">{{ $best_sellers[0]->getProduct->book_name ?? '-' }}</font></b></h5></a>
                    <h6 id="best_serie_set">{{ $best_sellers[0]->getProduct->writer ?? '-' }}</h6>
                    
                    @auth                  
                        <p></p>
                        <a href="javascript:void(0)" id="best_cart" data-id-product="{{ $best_sellers[0]->getProduct->id ?? '' }}"  class="add_cart btn btn-danger pl-2 pr-2 {{ !empty($best_sellers[0]->getApproveReadEbook->id) ? 'disabled' : '' }}" data-has-product="{{ !empty($best_sellers[0]->getCartEbook->id) ?? '' }}" data-type="ebook"><font>เพิ่มใส่ตระกร้า </font> <span class="vr"></span><i class="fas fa-cart-plus fa-1x"></i></a>
                    @else
                          
                        <a href="{{ route('login') }}" class="btn btn-danger mt-3 pl-2 pr-2"><font>เพิ่มใส่ตระกร้า </font> <span class="vr"></span><i class="fas fa-cart-plus fa-1x"></i></a>
                        
                    @endauth
                </div>  

            </div>
        </div>
    </section>

   

      

    <!-- ebook_real -->
    <section class="women-banner spad py-4">
        <div class="container " >

            <div class="head_text"><h2 class="head_text_string"><img src="{{ url('images/bg/book.png') }}" width="70px" height="70px"> นิยาย E-Books มาใหม่</h2>
                <div class="option_head_text">
                    <a href="{{ url('ebook/productsEbook') }}" class="btn btn-outline-danger p-2 pl-3 pr-3" style="float: right;"><font size="3" color="">ดูทั้งหมด</font></a>
                </div>
            </div>
                    <div class="row display-flex rcorners">
                        @foreach ($products_ebook_news as $products_new)
                            <div class="product-item  product_img two    rcorners  col-12 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 center text-center">
                                <div class="card rcorners "  >
                                    <!-- <img class="" src=".../100px180/?text=Image cap" alt="Card image cap"> -->

                                    <div style=" max-width: 55vh;" class="rcorners card-img-top ">
                                        <figure class='book3d '>
                                          <!-- Front -->
                                          <ul class='hardcover_front '>
                                            <li style="background-color: #43202F; " class="pi-pic">
                                                @if(!empty($products_new->picture)) 
                                                        <img class="cropped1"   src="{{ asset('storage/book-images/'.$products_new->picture) }}" >
                                                @else
                                                    <img class="cropped1" src="{{ asset('img/no_pic.png') }}" >                                
                                                @endif

                                                
                                                @auth
                                                <div class="icon_heart">
                                                    @if(empty($products_new->getFavorBook->id))
                                                    <a href="javascript:void(0)" data-id-product="{{ $products_new->id ?? '' }}" data-id-favor="{{ $products_new->getFavorBook->id ?? '' }}" data-type="ebook" class="add_mini_heart">
                                                    <i style="color: black;background-color: white;" class="far fa-heart fa-heart-book"></i></a>                                    
                                                    @else
                                                    <a href="javascript:void(0)" data-id-product="{{ $products_new->id ?? '' }}" data-id-favor="{{ $products_new->getFavorBook->id ?? '' }}" data-type="ebook" class="add_mini_heart">
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
                                            <a href="{{ url('ebook/productsEbook/detail/'.$products_new->id ?? '') }}"><font class="pl-4" size="4" color="black"><b>{{ $products_new->book_name ?? '-' }}</b></font></a>                                           
                                            <a href="{{ url('ebook/productsEbook/serie/'.$products_new->writer ?? '') }}" >
                                              <font class="pl-4" size="3" color="SlateGrey">{{ $products_new->writer ?? '-' }}<br></font> <!--ซีรีส์ชุด -->
                                            </a>           
                                        </div>
                                        
                                    </div>
                                    <div class="" style="width:100%;height: 70px;">
                                        <table  style="width:100%;height: 100%;">
                                            <tbody>
                                                <tr>                                                    
                                                    <td class="text-left pl-4">
                                                      @if(!empty($products_new->getApproveReadEbook->id))
                                                        <strong><font size="4"  color="red" class="" >ซื้อแล้ว</font></strong>
                                                      {{-- @elseif($products_new->tmp_cart_id)
                                                        <strong><font size="4"  color="red" class="" >อยู่ในตระกร้า</font></strong> --}}
                                                      @else
                                                        <b><font size="4"  color="red" class="" >฿{{number_format($products_new->product_price ?? '0')}}</font></b>                                                
                                                        <s><font size="4"  color="black" class="" >฿{{number_format($products_new->price ?? '0')}}</font></s>
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
                                                      <a href="javascript:void(0)" class="add_cart btn btn-danger p-2 rcorners2 hvr-grow shadow1 {{ $products_new->getApproveReadEbook ? 'disabled' : '' }}" data-has-product="{{ $products_new->getCartEbook->id ?? '' }}" style="width: 50px" data-id-product="{{ $products_new->id ?? '' }}" data-type="ebook" ><i class="fas fa-shopping-cart"></i></a>                                                                  
                                                    @else    
                                                        <a href="{{ route('login') }}" class="btn btn-danger p-2 rcorners2 hvr-grow shadow1" style="width: 50px"><i class="fas fa-shopping-cart"></i></a>    
                                                    @endauth
                                                        <a href="{{ url('file/'.$products_new->attachment) }}" class="btn btn-danger p-2 rcorners2 hvr-grow shadow1 {{ !$products_new->attachment ? 'disabled': '' }}" style="width: 50px" target=_blank  title="อ่านเรื่องย่อ"  ><i class="far fa-file-pdf"></i></a>                                                                            
                                                        <a href="{{ url('ebook/productsEbook/detail/'.$products_new->id) }}" class="btn btn-danger p-2 rcorners2 hvr-grow shadow1 " style="width: 50px"><i class="far fa-eye"></i></a>
                                                        <div style="display: inline;" class="link_image_popups">
                                                            <a href="{{ url('storage/book-images/'.$products_new->picture) }}" class="btn btn-danger p-2 image_popup_link rcorners2 hvr-grow shadow1" data-effect="mfp-zoom-out" style="width: 50px" ><i class="fas fa-expand-arrows-alt"></i></a>                                                      
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

        </div>
    </section>
   
                                      


    {{-- <section class="women-banner spad py-4">
        <div class="container " >
        <!-- style="background-color:rgba(238, 81, 255, .1); border: 2px solid Purple;" -->
            <div class="head_text"><h2 class="head_text_string">นิยาย E-Books มาใหม่</h2>
                <div class="option_head_text">
                    <a href="{{ url('ebook/productsEbook') }}" style="float: right;">ดูทั้งหมด</a>
                </div>
            </div>
                    <div class="row display-flex">
                        @foreach ($products_ebook_news as $products_new)
                            <div class="product-item    col-12 col-xs-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 center text-center">
                                <div class="card" >
                                    <!-- <img class="" src=".../100px180/?text=Image cap" alt="Card image cap"> -->
                                    <div class="card-header">
                                        
                                        <div class="pi-pic" 
                                            data-aos="fade-up"
                                            data-aos-anchor-placement="top-bottom">
                                            @if($products_new->product_image) 
                                            
                                            <!--
                                                    <a href="public/storage/book-images/{{ $products_new->product_image  }}" class="image-popup-no-margins  hvr-grow"  >
                                                        <img class="cropped1" style="background-color: HoneyDew;border: 2px solid DarkCyan;" src="{{ asset('storage/book-images/thumbnail/'.$products_new->product_thumb_image) }}" >
                                                    </a> -->
                                                    <!-- pic_test -->
                                                    <a href="{{ url('storage/book-images/'.$products_new->product_image) }}" class="image-popup-no-margins hvr-grow " >
                                                        <img class="cropped1 parent" style="background-color: HoneyDew;border: 2px solid DarkCyan; " src="{{ asset('storage/book-images/'.$products_new->product_image) }}" >
                                                    </a>
                                            @else
                                                <img class="cropped1" style="background-color: HoneyDew;border: 2px solid DarkCyan;" src="{{ asset('img/no_pic.png') }}" >                                
                                            @endif
                                            @auth
                                            <div class="icon">
                                                @if(empty($products_new->favor_book_id))
                                                <a href="javascript:void(0)" data-id-product="{{ $products_new->id_product }}" data-id-favor="{{ $products_new->favor_book_id }}"  class="add_mini_heart">
                                                <i style="color: HotPink;-webkit-text-stroke-width: 1px;
                                    -webkit-text-stroke-color: HotPink;" class="far fa-heart"></i></a>                                    
                                                @else
                                                <a href="javascript:void(0)" data-id-product="{{ $products_new->id_product }}" data-id-favor="{{ $products_new->favor_book_id }}" class="add_mini_heart">
                                                <i style="-webkit-text-fill-color: LightPink;
                                    -webkit-text-stroke-width: 3px;
                                    -webkit-text-stroke-color: HotPink; " class="fas fa-heart"></i></a>
                                                @endif
                                            </div>
                                            @endauth
                                            <ul>
                                            @auth
                                                <li class="w-icon active hvr-grow" >  
                                                    <a href="javascript:void(0)" data-id-product="{{ $products_new->id_product }}" data-type="ebook" class="add_cart"><i class="fas fa-cart-plus fa-1x"></i></a>
                                                </li>
                                            @else
                                                <li class="w-icon active hvr-grow">  
                                                    <a href="{{ route('login') }}" class="hvr-grow"><i class="fas fa-cart-plus fa-1x"></i></a>
                                                </li>
                                            @endauth
                                                <li class="quick-view hvr-grow"><a href="{{ url('ebook/productsEbook/detail').'/'.$products_new->id_product }}">+ View</a></li>
                                                @if($products_new->product_image) 
                                                <li class="w-icon hvr-grow">
                                                    <a href="{{ url('storage/book-images/'.$products_new->product_image) }}"  target="_blank" title="ดูรูปปก">
                                                        <i class="fas fa-search-plus"></i>
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>

                                    </div>
                                    <div class="card-body" style="background-color:White;border: 1px solid WhiteSmoke;">

                                        <div class="pi-text mt-1 text-left" >
                                            @if($products_new->product_name)
                                                <a href="{{ url('ebook/productsEbook/detail').'/'.$products_new->id_product }}"><font class="pl-2" size="4"  color="#ff4bc6">{{ $products_new->product_name }}</font></a>
                                            @endif
                                            @if($products_new->serie_set)
                                            <font class="pl-2" size="3" color="#824300">
                                                <!-- <b>ซีรีส์ชุด : </b> -->
                                                {{ $products_new->serie_set }}<br>
                                            </font>
                                            @else
                                            <font class="pl-2" size="3" color="#824300">-<br></font>
                                            @endif       
                                        </div>
                                        
                                    </div>
                                    <div class="card-footer">
                                        
                                        <div class="pi-text " >
                                            
                                            <div class="wrap_btn_book_list">
                                                <table class="table_btn_book_list" style="width:100%;">
                                                <tbody>
                                                    <tr style="width:100%;">
                                                        @if(!empty($products_new->product_pdf2))           
                                                        <td >
                                                        <div>
                                                            @if($products_new->product_pdf2)  
                                                            &nbsp;<a style="display: inline;" href="file/{{ $products_new->product_pdf2 }}" target=_blank  title="อ่านเรื่องย่อ"><img src="{{ asset('images/pdf_icon.png') }}" border=0 height=20></a>
                                                            @endif
                                                        </div>
                                                        </td>
                                                        @endif
                                                        
                                                        <td valign="middle"  class="" width="60%" height="100%"  align="center" >
                                                             @if($products_new->product_price)
                                            <!-- <b>ราคา : </b>
                                             -->
                                            <a href="javascript:void(0)" data-id-product="{{ $products_new->id_product }}" data-type="ebook" class="btn btn-outline-success add_cart "  >
                                                <b><font size="5" style="text-decoration: underline;" color="red" class="price-sale ">{{number_format($products_new->product_price ?? '0')}}</font></b><br>
                                                <font class="price " >
                                                    <del>
                                                      <span class="amount">{{ $products_new->alias_price }}</span>
                                                    </del>
                                                </font>
                                                <b><font color="#006400" class="">   บาท</font></b>
                                            </a>
                                            
                                            @else
                                            <a href=""  class="btn btn-outline-success "  ><b><font size="5" color="red">-</font> บาท</b></a>
                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach 
                    </div>
        </div>
    </section>  --}}


    <section class="py-2">
        <div class="container">
            <!-- Swiper -->
            <div class="row">
                
                <div class="col-lg-4 col-md-4 text-center">
                    <div id="fb-root"></div>
                    <div class="fb-page" style="width: 100%" data-href="https://web.facebook.com/lightoflovebooksfanpage/" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                        <blockquote cite="https://web.facebook.com/lightoflovebooksfanpage/" class="fb-xfbml-parse-ignore">
                            <a href="https://web.facebook.com/lightoflovebooksfanpage/">ไลต์ ออฟ เลิฟ บุ๊คส์ - เขียนฝัน แสนรัก แก้วชวาลา</a>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </section>
   
    
@endsection

@section('js')

{{-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v8.0&appId=2163051047291749&autoLogAppEvents=1" nonce="GPpWO7rR"></script> --}}

{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> --}}
{{-- <script type="text/javascript" src="../dist/fullpage.js"></script> --}}

<script>
    

  </script>


<script>
        $(document).ready(function() {
            
            var menu = ['Slide 1', 'Slide 2', 'Slide 3', 'Slide 4']
            new Swiper('.swiper_slide', {
                loop: true,
                slidesPerView: 1,
                speed: 400,
                spaceBetween: 10,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: true,
                },
                // disableOnInteraction: true,
                pagination: {
                el: '.swiper-pagination',
                        clickable: true,
                    
                },
                //Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
            new Swiper ('.swiper-container-best-test', {
                // loop: true,
                // speed: 400,
                // slidesPerView: 4,
                spaceBetween: 30,
                // autoplay: {
                //     delay: 2500,
                //     disableOnInteraction: true,
                // },
                
                breakpoints: {

                    0:{
                        slidesPerView:1
                    },
                    320: {
                        slidesPerView: 1,
                    },
                    480: {
                        slidesPerView: 1,
                    },
                    640:{
                        slidesPerView:1
                    },
                    960:{
                        slidesPerView:1
                    },
                    1200:{
                        slidesPerView:2
                    }
                    
                }
            });
            var swiper = new Swiper('.blog-slider', {
                spaceBetween: 30,
                effect: 'fade',
                loop: true,
                mousewheel: {
                    invert: false,
                },
                // autoHeight: true,
                pagination: {
                    el: '.blog-slider__pagination',
                    clickable: true,
                }
            });
            // new Swiper ('.swiper-container-best', {
            //     spaceBetween: 30,
            //     // autoplay: {
            //     //     delay: 2500,
            //     //     disableOnInteraction: true,
            //     // },
                
            //     breakpoints: {

            //         0:{
            //             slidesPerView:1
            //         },
            //         320: {
            //             slidesPerView: 1,
            //         },
            //         480: {
            //             slidesPerView: 2,
            //         },
            //         640:{
            //             slidesPerView:2
            //         },
            //         960:{
            //             slidesPerView:3
            //         },
            //         1200:{
            //             slidesPerView:3
            //         }
                    
            //     }
            // });
            // new Swiper ('.swiper-container-best', {
            //     // loop: true,
            //     // speed: 400,
            //     // slidesPerView: 4,
            //     spaceBetween: 30,
            //     autoplay: {
            //         delay: 2500,
            //         disableOnInteraction: true,
            //     },
                
            //     breakpoints: {

            //         0:{
            //             slidesPerView:1
            //         },
            //         320: {
            //             slidesPerView: 1,
            //         },
            //         480: {
            //             slidesPerView: 2,
            //         },
            //         640:{
            //             slidesPerView:2
            //         },
            //         960:{
            //             slidesPerView:3
            //         },
            //         1200:{
            //             slidesPerView:4
            //         }
                    
            //     }
            // });
            // new Swiper ('.swiper-container-pre', {
            //     // loop: true,
            //     // speed: 400,
            //     // // slidesPerView: 3,
            //     spaceBetween: 30,
            //     autoplay: {
            //         delay: 2500,
            //         disableOnInteraction: true,
            //     },
  
            //     breakpoints: {

            //         0:{
            //             slidesPerView:1
            //         },
            //         320: {
            //             slidesPerView: 1,
            //         },
            //         480: {
            //             slidesPerView: 2,
            //         },
            //         640:{
            //             slidesPerView:2
            //         },
            //         960:{
            //             slidesPerView:2
            //         },
            //         1200:{
            //             slidesPerView:3
            //         }
            //     }
            // });
            var mySwiper = document.querySelector('.swiper_slide').swiper
            // var mySwiperBest = document.querySelector('.swiper-container-best').swiper
            // var mySwiperPre = document.querySelector('.swiper-container-pre').swiper

            $(".swiper_slide").mouseenter(function() {
                mySwiper.autoplay.stop();
                // console.log('slider stopped');
            });

            $(".swiper_slide").mouseleave(function() {
                mySwiper.autoplay.start();
                // console.log('slider started again');
            });
            // $(".swiper-container-best").mouseenter(function() {
            //     mySwiperBest.autoplay.stop();
            //     console.log('slider stopped');
            // });

            // $(".swiper-container-best").mouseleave(function() {
            //     mySwiperBest.autoplay.start();
            //     console.log('slider started again');
            // });
            // $(".swiper-container-pre").mouseenter(function() {
            //     mySwiperPre.autoplay.stop();
            //     console.log('slider stopped');
            // });

            // $(".swiper-container-pre").mouseleave(function() {
            //     mySwiperPre.autoplay.start();
            //     console.log('slider started again');
            // });
        });
    
    $(function(){

        // $('.owl-carousel').owlCarousel({
        //     loop:false,
        //     stagePadding: 15,
        //     margin:10,
        //     nav:true,
        //     navText : ['<span class="uk-margin-small-right uk-icon" uk-icon="icon: chevron-left"></span>','<span class="uk-margin-small-left uk-icon" uk-icon="icon: chevron-right"></span>'],
        //     responsive:{
        //         0:{
        //             items:1
        //         },
        //         640:{
        //             items:2
        //         },
        //         960:{
        //             items:3
        //         },
        //         1200:{
        //             items:4
        //         }
        //     }
        // })
        var $owl = $('.owl-carousel');

        $owl.children().each( function( index ) {
            $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
            // $(this).attr( 'data-name', index );
            
            });

            $owl.owlCarousel({
                nav: true,
                navText: [
                    '<i class="fas fa-arrow-circle-left" style="color:red;background-color:white;border: 1px solid DarkRed;border-radius: 100%;" ></i>',
                    '<i class="fas fa-arrow-circle-right" style="color:red;background-color:white;border: 1px solid DarkRed;border-radius: 100%;" ></i>'
                ],
                navContainer: '.main-content .custom-nav',
                // autoplay:true,
                // autoplayTimeout:3000,
                // autoplayHoverPause:true,
                smartSpeed:1000,
                dots: false,
                center: true,
                loop: true,
                items: 3,
                margin:10,
                afterUpdate: function () {
                updateSize();
            },
        afterInit:function(){
            updateSize();
        },
            responsive:{
                0:{
                    items:1
                },
                640:{
                    items:2
                },
                960:{
                    items:3
                },
                1200:{
                    items:3
                }
            }
            });
          

            $(document).on('click', '.owl-item>div', function() {
                // see https://owlcarousel2.github.io/OwlCarousel2/docs/api-events.html#to-owl-carousel
                var $speed = 600;  // in ms
                // alert($(this).data( 'position' ));
                if($(this).data( 'approve_id' )){
                  $('#parent_price').html('<strong><font size="4"  color="red" class="" >ซื้อแล้ว</font></strong>');
                  $('#best_cart').addClass('disabled');
                }else{
                  $('#parent_price').html('<strong><font id="best_product_price"  style="color:red;" >฿</font></strong> '
                                        +'<s><font id="best_alias_price" >฿</font></s>'
                  );
                  
                }
                if(!$(this).data( 'approve_id' )){
                  $('#best_cart').removeClass('disabled');
                }
                $('#best_name').html($(this).data( 'name' ) ?? '-')
                $('#best_serie_set').html($(this).data( 'serie_set' ) ?? '-')
                $('#best_alias_price').html('฿'+$(this).data( 'alias_price' ) ?? '-')
                $('#best_product_price').html('฿'+$(this).data( 'product_price' ) ?? '-')              

                $('#best_cart').attr('data-id-product',$(this).data( 'id-product' ))
                // $('#best_cart').attr('data-blame-product',$(this).data( 'blame-product' ))
                // $('#best_cart').attr('data-buffet',$(this).data( 'buffet' ))
                // $('#best_cart').attr('data-can-discount',$(this).data( 'can-discount' ))
                $('#best_name_url').attr('href',"{{ url('ebook/productsEbook/detail') }}/"+$(this).data( 'id-product' ))

                
                // data-approve_id="{{ $best_seller->ebook_approve_id ?? '' }}" data-has_product
                
                
                
                $owl.trigger('to.owl.carousel', [$(this).data( 'position' ), $speed] );
            });
            function updateSize(){
                var minHeight=parseInt($('.owl-item').eq(0).css('height'));
                $('.owl-item').each(function () {
                    var thisHeight = parseInt($(this).css('height'));
                    minHeight=(minHeight<=thisHeight?minHeight:thisHeight);
                });
                $('.owl-wrapper-outer').css('height',minHeight+'px');

                /*show the bottom part of the cropped images*/
                $('.owl-carousel .owl-item img').each(function(){
                    var thisHeight = parseInt($(this).css('height'));
                    if(thisHeight>minHeight){
                        $(this).css('margin-top',-1*(thisHeight-minHeight)+'px');
                    }
                });

            }

        
        // $owl.on('changed.owl.carousel', function(event) {
        //     var item      = event.item.index;
        //     alert($(this).data( 'name' ))
        // })
        $owl.on('changed.owl.carousel',function(property){
            var current = property.item.index;
            var e = $(property.target).find(".owl-item").eq(current).children();
            // var price = $(property.target).find(".owl-item").eq(current).children().data('price');
            // var witer = $(property.target).find(".owl-item").eq(current).children().data('witer');
            $('#best_name').html(e.data('name') )
            $('#best_serie_set').html(e.data('serie_set') )
            if(e.data('alias_price') || e.data('product_price')){
                $('#parent_price').html('<strong><font id="best_product_price"  style="color:red;" >฿</font></strong> '
                                    +'<s><font id="best_alias_price" >฿</font></s>'
                );
                if(!e.data('approve_id')){
                  $('#best_cart').removeClass('disabled');
                }
            }
            // alert(e.data('price'));
            if(e.data('alias_price')){
                var text_alias_price = '฿'+ e.data('alias_price') ;
                
                $('#best_alias_price').html(text_alias_price);
            }
            if(e.data('product_price')){
                var text_product_price = '฿'+ e.data('product_price') ;
                
                $('#best_product_price').html(text_product_price);
            }  
            
            
            if(e.data('approve_id')){
              $('#parent_price').html('<strong><font size="4"  color="red" class="" >ซื้อแล้ว</font></strong>');
              $('#best_cart').addClass('disabled');
            }
            
            // alert(e.data( 'id-product' ));

            if(e.data( 'id-product' )){
              $('#best_cart').attr('data-id-product',e.data( 'id-product' ))
              $('#best_name_url').attr('href',"{{ url('ebook/productsEbook/detail') }}/"+e.data( 'id-product' ))
            }
            
            // $('#best_cart').attr('data-blame-product',e.data( 'blame-product' ))
            // $('#best_cart').attr('data-buffet',e.data( 'buffet' ))
            // $('#best_cart').attr('data-can-discount',e.data( 'can-discount' ))

            // var src = $(property.target).find(".owl-item")
            // console.log('Image current is ' + e.data('name'));
        });



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
            var Item_id = $(this).attr('data-id-product');
            var blame_product = $(this).data('blame-product');
            var buffet = $(this).data('buffet');
            var can_discount = $(this).data('can-discount');
            var type = $(this).data('type');
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
              $.ajax({
                  type: "POST",
                  url: "{{ url('cart') }}",
                  data:{_token: "{{ csrf_token() }}", product_id:Item_id , user_id: user_id ,
                  username: username , blame_product: blame_product , buffet: buffet, can_discount:can_discount,type:type },
                  success: (response) => {    
                      if ($.isEmptyObject(response.error)) {
                              console.log(response)
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
                          console.log(response)
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
              })
            }
        });

        $('body').on('click', '.add_mini_heart', function() {
            var Item_id = $(this).data('id-product');
            var favor = $(this).data('id-favor') ?? '' ;
            var type = $(this).data('type') ?? '' ;
            if(favor){
                var status = 'delete_mini_heart';
            }else{
                var status = 'add_mini_heart';
            }
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
</script>



@endsection