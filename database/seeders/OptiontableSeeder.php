<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Option;
class OptiontableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {


    $options = array(
      array('id' => '1', 'key' => 'primary_data', 'value' => '{"logo":"\\/uploads\\/2023\\/07\\/1689248021hH7LW2wg2bpg0zMmCgU1.png","favicon":"uploads\\/favicon.png","contact_email":"contact@email.com","contact_phone":"1234567890","address":"Somewhere, Global","socials":{"facebook":"https:\\/\\/www.facebook.com\\/","youtube":"https:\\/\\/youtube.com\\/","twitter":"https:\\/\\/twitter.com\\/","instagram":"https:\\/\\/www.instagram.com\\/","linkedin":"https:\\/\\/linkedin.com\\/"},"footer_logo":"\\/uploads\\/2023\\/07\\/1689248021hH7LW2wg2bpg0zMmCgU1.png"}', 'lang' => 'en'),
      array('id' => '2', 'key' => 'tax', 'value' => '0', 'lang' => 'en'),
      array('id' => '3', 'key' => 'base_currency', 'value' => '{"name":"USD","icon":"$","position":"left"}', 'lang' => 'en'),
      array('id' => '4', 'key' => 'invoice_data', 'value' => '{"company_name":"Ionfirm","address":"somewhere","city":"SM","country":"Global","post_code":"123456"}', 'lang' => 'en'),
      array('id' => '5', 'key' => 'languages', 'value' => '{"en":"English"}', 'lang' => 'en'),
      array('id' => '6', 'key' => 'seo_home', 'value' => '{"site_name":"Home","matatag":"","matadescription":"","twitter_site_title":"home","preview":""}', 'lang' => 'en'),
      array('id' => '7', 'key' => 'seo_blog', 'value' => '{"site_name":"Blogs","matatag":"","matadescription":"","preview":""}', 'lang' => 'en'),
      array('id' => '8', 'key' => 'seo_about', 'value' => '{"site_name":"About Us","matatag":"","matadescription":"","preview":""}', 'lang' => 'en'),
      array('id' => '9', 'key' => 'seo_pricing', 'value' => '{"site_name":"Pricing","matatag":"","matadescription":"","preview":""}', 'lang' => 'en'),
      array('id' => '10', 'key' => 'seo_contact', 'value' => '{"site_name":"Contact Us","matatag":"","matadescription":"","preview":""}', 'lang' => 'en'),
      array('id' => '11', 'key' => 'seo_faq', 'value' => '{"site_name":"Faq","matatag":"","matadescription":"","preview":""}', 'lang' => 'en'),
      array('id' => '12', 'key' => 'seo_team', 'value' => '{"site_name":"Our Team","matatag":"","matadescription":"","preview":""}', 'lang' => 'en'),
      array('id' => '13', 'key' => 'seo_features', 'value' => '{"site_name":"Features","matatag":"","matadescription":"","preview":""}', 'lang' => 'en'),
      array('id' => '14', 'key' => 'seo_how_its_works', 'value' => '{"site_name":"How its work","matatag":"","matadescription":"","preview":""}', 'lang' => 'en'),
      array('id' => '15', 'key' => 'contact-page', 'value' => '{"address":"Somewhere, Global,","country":"Global 123456,GL","map_link":"https:\/\/www.google.com\/maps","contact1":"1234567890","contact2":"1234567890","email1":"support@email.com","email2":"contact@email.com"}', 'lang' => 'en'),
      array('id' => '16', 'key' => 'banner', 'value' => '{"phone_image_1":"\\/uploads\/2023\/07\/1689923457QhzwCWj99WL6f41UBHgW.png","phone_image_2":"\\/uploads\/2023\/07\/1689924738gt1rdvhoAHo2IapTRUaB.png","phone_image_3":"\\/uploads\/2023\/07\/1689928142oYi04rnhNDRPuRTX1Rmr.png","banner_header":"Revolutionize Your Marketing with WhatsCloud","usedthis":"50k+ Used This Platform","btnfirst":"Explore","btnsecond":"Sign In"}', 'lang' => 'en'),
      array('id' => '17', 'key' => 'features', 'value' => '{"feature_image":"\\/uploads\/2023\/07\/16899299773QP4MmQdCj0eNyvLnIvB.png","feature_header":"Features that makes platform different!","feature_subheader":"Discover the Array of Distinctive Features Setting Our Platform Apart","feature_1":"Secure API","feature_1_details":"Ensure Ironclad Security with our Reliable and Encrypted API Connection for Peace of Mind.","feature_2":"Template Messaging","feature_2_details":"Effortlessly Create and Send Customizable Template Messages for Engaging and Consistent Communication.","feature_3":"Auto Responder","feature_3_details":"Deliver Instant Replies and Streamline Communication with Automated Responses for Enhanced Customer Engagement.","feature_4":"24-7 Availablity","feature_4_details":"Experience Uninterrupted Access Anytime, Anywhere with our 24\/7 Availability for Seamless webhook Communication."}', 'lang' => 'en'),
      array('id' => '18', 'key' => 'about_section', 'value' => '{"frame_image":"\\/uploads\/2023\/07\/1689930896RqN0uj9bXBeV24CJNcKV.png","frame_image_2":"\\/uploads\/2023\/07\/1689234953Np7Efhu6VmYKmsRX1MRb.png","about_header":"Empowering Connections, Transforming Experiences","about_subheader":"\"WhatsCloud is a revolutionary platform that empowers connections and transforms experiences. With its cutting-edge features and seamless integration, WhatsCloud revolutionizes communication, enabling businesses to reach new heights. Experience enhanced engagement, streamlined workflows, and unparalleled convenience, all within a secure and reliable environment. Join WhatsCloud and unlock the power of connected communication.","feature_image_2":null,"about_api":"1200","satisfied_user":"937","customer_review":"772","about_countries":"63"}', 'lang' => 'en'),
      array('id' => '19', 'key' => 'overview', 'value' => '{"overview_image_1":"\\/uploads\/2023\/07\/1689243060p2FHn4w9Wq8rrYA0kF5F.png","overview_image_2":"\\/uploads\/2023\/07\/1689243060jaJk7IZY9OLt8SUNt8km.png","overview_image_3":"\\/uploads\/2023\/07\/1689243060MbsrkuaHHC5dNb1K9k9A.png","overview_header":"Embrace the Future with WhatsCloud","overview_subheader":"Welcome to WhatsCloud, the innovative platform designed to revolutionize communication. Seamlessly connect with your audience, streamline workflows, and unlock new opportunities for growth. Experience the power of advanced features, robust security, and unparalleled convenience. Embrace the future of communication with WhatsCloud.","overview_title_1":"Create & Send Templates","overview_subtitle_1":"Effortlessly create and send customizable templates for engaging and consistent communication with ease and efficiency.","overview_title_2":"Live Chat & Bulk Messaging","overview_subtitle_2":"Experience seamless live chat functionality and send bulk messages for efficient and effective communication with your audience.","overview_title_3":"Effortless Scheduling Experience","overview_subtitle_3":null}', 'lang' => 'en'),
      array('id' => '20', 'key' => 'work', 'value' => '{"step_image_1":"\\/uploads\/2023\/07\/1689245834tJGWFYTxCNIqycDmIvMy.jpg","step_image_2":"\\/uploads\/2023\/07\/1689245834sVbI8r1CEg6Dv4mAC3n7.jpg","step_image_3":"\\/uploads\/2023\/07\/1689245834iwbfQlcsm9jOsiX6r1SS.jpg","video_image":"\\/2023\/07\/16892458346uaAcMQyjZPetSmRBXU3.jpeg","work_header":"How to Connect - 3 easy steps","work_subheader":"Effortlessly integrate your WhatsApp Cloud API with our platform in three simple steps and harness the potential of seamless communication.","step_title_1":"Set Up Your Facebook Developer Account","step_subtitle_1":"Create an App","step_description_1":"Initiate the process by creating an app on your Facebook Developer Account.","step_title_2":"Select Business as Your App Type","step_subtitle_2":"Provide Basic Business Information","step_description_2":"Enter essential details about your business to proceed with the integration.","step_title_3":"Access WhatsApp Integration","step_subtitle_3":"Accept Terms and Conditions","step_description_3":"Scroll down and click Continue to agree to WhatsApp Cloud APIs terms and conditions. Fill in your business information, connect your phone number, and start utilizing WhatsApp Cloud.","video_header":null,"video_url":"https:\/\/YouTube.com"}', 'lang' => 'en'),
      array('id' => '21', 'key' => 'downlaod', 'value' => '{"download_header":"Get Unlimited Experience With Whatscloud","download_subheader":"Start it Today","hero_image_1":null,"hero_image_2":null}', 'lang' => 'en'),
    );

    Option::insert($options);

  }
}
