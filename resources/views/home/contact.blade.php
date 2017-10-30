@extends('layouts.frontEnd')

@section('content')



 <div class="body_content">

    <section class="contact-wrap sec-pad">

      <div class="container">

        <div class="contact-sec">

          <div class="row">

              <div class="contact-form">

               <div class="col-lg-5 col-md-5">

                <h1>Contact Us</h1>

                <div class="form-top">

                  <ul>

                    <li>

                      <div class="contact-icon">

                        <label> <i class="fa fa-mobile" aria-hidden="true"></i> </label>

                      </div>

                      <div class="contact-text"> <strong>PHONE</strong> <span>(33) 3566 8890</span> </div>

                    </li>

                    <li>

                      <div class="contact-icon">

                        <label> <i class="fa fa-map-marker" aria-hidden="true"></i> </label>

                      </div>

                      <div class="contact-text"> <strong>ADDRESS</strong> <span>Washington, DC 20500, United Arab Emirates</span> </div>

                    </li>

                    <li>

                      <div class="contact-icon">

                        <label> <i class="fa fa-envelope" aria-hidden="true"></i> </label>

                      </div>

                      <div class="contact-text"> <strong>EMAIL</strong> <span>info@kuwpons.com.au</span> </div>

                    </li>

                  </ul>

                </div>

            </div>

               <div class="col-lg-7 col-md-7">

                <h1>Keep In Touch</h1>

              <div class="contact-form-btm">

                <form action="#" method="post">

                  <form-field>

                    <part-field>

                      <input type="text" name="" value="" placeholder="First Name">

                    </part-field>

                    <part-field>

                      <input type="text" name="" value="" placeholder="Last Name">

                    </part-field>

                  </form-field>

                  <form-field>

                    <input type="email" name="" value="" placeholder="Email">

                  </form-field>

                  <form-field>

                    <input type="tel" name="" value="" placeholder="Phone">

                  </form-field>

                  <form-field>

                    <textarea placeholder="">

                                     

                   </textarea>

                  </form-field>

                  <form-field>

                    <input type="submit" name="" value="Submit">

                  </form-field>

                </form>

              </div>

            </div>

            </div>

          </div>

        </div>

      </div>

      <div class="map-sec">

          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d230171.47334107943!2d-74.13739356145635!3d40.71307452548784!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sin!4v1503299833597" width="100%" height="460px" frameborder="0" style="border:0" allowfullscreen></iframe>

      </div>

    </section>

   {{--  <section class="newslatter-sec">

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

