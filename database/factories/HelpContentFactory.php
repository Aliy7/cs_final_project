<?php

namespace Database\Factories;

use App\Models\HelpContent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class HelpContentFactory extends Factory
{
    protected $model = HelpContent::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


     public function definition(): array
     {
         $faqs = [
             [
                 'title' => 'What do I need to fill out when uploading a new food listing?',
                 'content' => 'Ensure you fill in all the necessary details like food name, description, category, price, and availability.',
                 'category' => 'Listing Process'
             ],
             [
                 'title' => 'Why do I need to add a picture when listing food?',
                 'content' => 'Adding a picture lets you see the food before reserving it. It helps you choose better and makes your browsing experience more enjoyable.',
                 'category' => 'Listing Process'
             ],
             [
                 'title' => 'How many food items do I need to post?',
                 'content' => 'You need to post more than one food item so that there are plenty of options for everyone.',
                 'category' => 'Listing Process'
             ],
             [
                 'title' => 'What should I include about allergens?',
                 'content' => 'It\'s important to mention any allergens in the food to help people with dietary restrictions make safe choices.',
                 'category' => 'Health and Safety'
             ],
             [
                 'title' => 'Why do I need to mention the location of the food?',
                 'content' => 'Mentioning the location helps you know how close the food is to your location. It makes it easier to plan for picking it up.',
                 'category' => 'Logistics'
             ],
             [
                 'title' => 'How do I show that the food is available for reservation?',
                 'content' => 'Just tick the availability checkbox to let others know that the food is ready to be reserved.',
                 'category' => 'Reservation Process'
             ],
             [
                 'title' => 'How do I finish uploading my food listing?',
                 'content' => 'Once you\'ve filled in all the necessary fields and ticked the availability checkbox, click the "Upload Food Listing" button to submit it.',
                 'category' => 'Listing Process'
             ],
             [
                 'title' => 'Do I need approval before reserving the listed food?',
                 'content' => 'Yes, our team needs to approve your application before you can reserve any listed food items.',
                 'category' => 'Reservation Process'
             ],
             [
                 'title' => 'How long does it take for my application to be approved?',
                 'content' => 'Our team usually takes one to three working days to review and approve your application. We\'ll email you once it\'s approved.',
                 'category' => 'Reservation Process'
             ],
             [
                 'title' => 'What happens after I reserve a listed food item?',
                 'content' => 'Once our team approves your reservation, you can go ahead and collect the food from the location mentioned in the listing.',
                 'category' => 'Reservation Process'
             ],
             [
                 'title' => 'How can I change my profile information?',
                 'content' => 'You can update your profile on the "My Update" page. There, you can edit and save any changes to your information.',
                 'category' => 'Account Management'
             ],
             [
                 'title' => 'How do I get in touch with your team?',
                 'content' => 'Just click on the footer at the bottom of the screen and select the option to contact us. Fill in the required fields in the form and click "Submit" to send your message.',
                 'category' => 'Contact Us'
             ],
             [
                 'title' => 'How can I change my password?',
                 'content' => 'If you need to update your password, go to the login page and click on "Forgot Password." Follow the instructions in the email notification you receive to reset your password securely.',
                 'category' => 'Account Management'
             ]
         ];
 
         $faq = $faqs[array_rand($faqs)]; 
 
         return [
             'title' => $faq['title'],
             'content' => $faq['content'],
             'category' => $faq['category'],
             'user_id' => 1
         ];
     }
}
