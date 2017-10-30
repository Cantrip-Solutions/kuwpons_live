@extends('layouts.frontEnd')

@section('content')



<div class="body_content">

    <section class="about-sec">

      <div class="container">

        <h1>About Us</h1>

        <div class="row">

        <div class="col-lg-12 col-md-12">

        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla libero velit, venenatis eget lectus sit amet, sagittis vulputate nibh. Fusce gravida velit leo, non blandit ligula aliquet eu. Donec fermentum sem dignissim cursus volutpat. Morbi orci leo, laoreet nec pharetra eu, euismod sit amet sem. Donec eget neque enim. Nullam augue nibh, mollis vel lectus imperdiet, laoreet mattis odio. Nulla massa tellus, tempor sed felis et, tristique ultricies augue. Vivamus at condimentum turpis. Quisque euismod at enim sed mollis. Pellentesque blandit, lacus non imperdiet pulvinar, urna felis vulputate tellus, vitae aliquam leo dolor sit amet ligula. Nam eget cursus ipsum, vel lobortis orci. Aliquam erat volutpat. Aliquam in maximus turpis. Aliquam in odio et quam commodo gravida a vitae nibh. Quisque molestie nec eros eu sodales.</p>

        <p>Duis scelerisque, tortor vitae euismod viverra, risus leo luctus felis, a bibendum magna ante in quam. Quisque posuere feugiat consequat. Vestibulum efficitur ipsum quis nulla posuere dapibus. Vivamus eu ultrices sapien. Nunc sodales ullamcorper nibh vel laoreet. Aenean tellus mauris, hendrerit ut turpis at, interdum faucibus magna. Donec nec dui volutpat, lacinia sem a, fermentum enim. Quisque ut nulla non nisl commodo luctus. Nunc ac nunc ac risus dignissim iaculis sit amet consectetur libero. Cras at purus luctus urna molestie dignissim. Proin aliquet ultrices turpis. Vestibulum consectetur lobortis massa, non elementum leo fringilla vitae. Maecenas sed tellus sed augue suscipit efficitur. Maecenas sed viverra purus.</p>

        <p>Sed felis eros, tincidunt vitae erat in, maximus suscipit enim. Nam quis nibh at orci suscipit porta at et massa. Pellentesque eget nulla mollis tellus posuere congue vitae id lacus. Aenean pretium nunc neque. Praesent at urna in ipsum semper lacinia. Quisque vitae iaculis purus, ut molestie ligula. Mauris nec varius sapien. Donec congue dui leo, quis suscipit eros tristique et. Suspendisse nec ultrices justo. Fusce et orci ante. Mauris volutpat mattis diam a euismod.</p>

        <p>Fusce fringilla turpis quis mi pulvinar, non mattis elit consequat. Nam ultricies tincidunt purus, a sagittis ligula eleifend eu. </p>

        </div>

        </div>

        <div class="about-img">

        <div class="row">

            <div class="col-lg-6 col-md-6 col-xs-6">

              <figure> 

                <img src="{{ URL::to('/') }}/public/images/html/about-1.jpg" alt=""/>

              </figure>

            </div>

            

            <div class="col-lg-6 col-md-6 col-xs-6">

              <figure> 

                <img src="{{ URL::to('/') }}/public/images/html/about-2.jpg" alt=""/>

              </figure>

            </div>



        </div>

        </div>

      </div>

    </section>

    

    {{-- <section class="newslatter-sec">

      <div class="container">

        <div class="row">

          <div class="col-lg-5">

            <h1>NEWSLETTER SIGNUP</h1>

          </div>

          <div class="col-lg-7 no-padding">

            <div class="newslatter-name">

              <input class="form-control" type="text" placeholder="Name"/>

              <input class="form-control" type="text" placeholder="Email"/>

              <button class="defaultbtn btn-green">Subscribe!</button>

            </div>

          </div>

        </div>

      </div>

    </section> --}}

  </div>

@endsection