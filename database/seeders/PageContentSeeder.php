<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    public function run()
    {
        // Home Page Content
        $this->createHomePageContent();

        // About Page Content
        $this->createAboutPageContent();

        // Contact Page Content
        $this->createContactPageContent();

        // Prayer Room Page Content
        $this->createPrayerRoomPageContent();

        // Stream Page Content
        $this->createStreamPageContent();

        // Radio Page Content
        $this->createRadioPageContent();

        // Groups Page Content
        $this->createGroupsPageContent();

        // Testimonies Page Content
        $this->createTestimoniesPageContent();

        // News Page Content
        $this->createNewsPageContent();

        // Events Page Content
        $this->createEventsPageContent();
    }

    private function createHomePageContent()
    {
        // Hero Section
        PageContent::create([
            'page' => 'home',
            'section' => 'hero',
            'key' => 'hero_title',
            'title' => 'ISM Ministers Prayer Network',
            'subtitle' => 'United in Prayer, Strengthened in Faith',
            'content' => 'Join a community of believers committed to intercessory prayer and spiritual growth.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Welcome Section
        PageContent::create([
            'page' => 'home',
            'section' => 'welcome',
            'key' => 'welcome_title',
            'title' => 'Welcome to ISM Ministers Prayer Network',
            'content' => '<p>We are a vibrant community of ministers and believers dedicated to the power of prayer. Our mission is to unite Christians worldwide in intercessory prayer, fostering spiritual growth and community.</p><p>Through our online platform, you can connect with prayer groups, share prayer requests, and experience the transformative power of collective prayer.</p>',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Features Section
        PageContent::create([
            'page' => 'home',
            'section' => 'features',
            'key' => 'features_title',
            'title' => 'Our Ministries',
            'subtitle' => 'Discover the ways we serve and grow together',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'home',
            'section' => 'features',
            'key' => 'feature_prayer_groups',
            'title' => 'Prayer Groups',
            'content' => 'Join or create prayer groups for targeted intercession and community building.',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'home',
            'section' => 'features',
            'key' => 'feature_resources',
            'title' => 'Prayer Resources',
            'content' => 'Access guides, scriptures, and tools to enhance your prayer life.',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'home',
            'section' => 'features',
            'key' => 'feature_events',
            'title' => 'Prayer Events',
            'content' => 'Participate in scheduled prayer sessions and worship events.',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // CTA Section
        PageContent::create([
            'page' => 'home',
            'section' => 'cta',
            'key' => 'cta_title',
            'title' => 'Ready to Join Our Prayer Community?',
            'content' => 'Take the first step towards a deeper prayer life and meaningful connections.',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }

    private function createAboutPageContent()
    {
        // Hero Section
        PageContent::create([
            'page' => 'about',
            'section' => 'hero',
            'key' => 'hero_title',
            'title' => 'About Us',
            'subtitle' => 'Our Story, Mission, and Vision',
            'content' => 'Learn more about ISM Ministers Prayer Network and our commitment to prayer.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Mission Section
        PageContent::create([
            'page' => 'about',
            'section' => 'mission',
            'key' => 'mission_title',
            'title' => 'Our Mission',
            'content' => '<p>To create a global network of intercessors who unitedly seek God\'s face, lifting up the church, nations, and individuals in prayer.</p><p>We believe in the transformative power of prayer and strive to equip believers with resources and community for effective intercession.</p>',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Vision Section
        PageContent::create([
            'page' => 'about',
            'section' => 'vision',
            'key' => 'vision_title',
            'title' => 'Our Vision',
            'content' => '<p>A world where Christians are unified in prayer, where barriers are broken, and where God\'s presence transforms lives and communities through the ministry of intercession.</p>',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Values Section
        PageContent::create([
            'page' => 'about',
            'section' => 'values',
            'key' => 'values_title',
            'title' => 'Our Core Values',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'about',
            'section' => 'values',
            'key' => 'value_unity',
            'title' => 'Unity',
            'content' => 'We believe in the power of unified prayer and the strength that comes when believers pray together.',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'about',
            'section' => 'values',
            'key' => 'value_faith',
            'title' => 'Faith',
            'content' => 'We operate in unwavering faith, believing that God hears and answers prayers according to His will.',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'about',
            'section' => 'values',
            'key' => 'value_love',
            'title' => 'Love',
            'content' => 'We approach prayer with hearts full of love for God and for one another.',
            'sort_order' => 4,
            'is_active' => true,
        ]);
    }

    private function createContactPageContent()
    {
        // Hero Section
        PageContent::create([
            'page' => 'contact',
            'section' => 'hero',
            'key' => 'hero_title',
            'title' => 'Contact Us',
            'subtitle' => 'We\'d Love to Hear from You',
            'content' => 'Get in touch with ISM Ministers Prayer Network for inquiries, prayer requests, or partnership opportunities.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Contact Info
        PageContent::create([
            'page' => 'contact',
            'section' => 'info',
            'key' => 'address',
            'title' => 'Our Address',
            'content' => '123 Prayer Avenue, Lagos, Nigeria',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'contact',
            'section' => 'info',
            'key' => 'email',
            'title' => 'Email Us',
            'content' => 'info@ismprayer.org',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'contact',
            'section' => 'info',
            'key' => 'phone',
            'title' => 'Call Us',
            'content' => '+234 123 456 7890',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // Form Section
        PageContent::create([
            'page' => 'contact',
            'section' => 'form',
            'key' => 'form_title',
            'title' => 'Send Us a Message',
            'content' => 'Fill out the form below and we\'ll get back to you as soon as possible.',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }

    private function createPrayerRoomPageContent()
    {
        // Hero Section
        PageContent::create([
            'page' => 'prayer-room',
            'section' => 'hero',
            'key' => 'hero_title',
            'title' => 'Prayer Room',
            'subtitle' => 'Enter the sacred space where heaven meets earth',
            'content' => 'Join our virtual prayer room for guided prayer, scripture meditation, and community intercession.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Welcome Section
        PageContent::create([
            'page' => 'prayer-room',
            'section' => 'welcome',
            'key' => 'welcome_title',
            'title' => 'Welcome to Our Virtual Prayer Room',
            'content' => '<p>Step into this sacred digital sanctuary where believers from around the world gather in spirit to commune with God. Here, prayer transcends time and space as we unite our hearts in worship, intercession, and thanksgiving.</p><p>Whether you\'re seeking peace, guidance, healing, or simply desiring to draw closer to God, this prayer room provides a dedicated space for intimate fellowship with the Divine.</p>',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Features Section
        PageContent::create([
            'page' => 'prayer-room',
            'section' => 'features',
            'key' => 'features_title',
            'title' => 'Prayer Room Features',
            'subtitle' => 'Experience Sacred Moments',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'prayer-room',
            'section' => 'features',
            'key' => 'feature_guided_prayer',
            'title' => 'Guided Prayer',
            'content' => 'Follow structured prayer guides for different seasons and needs in your spiritual journey.',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'prayer-room',
            'section' => 'features',
            'key' => 'feature_scripture',
            'title' => 'Scripture Meditation',
            'content' => 'Dive deep into God\'s Word with curated verses and reflections for prayer and contemplation.',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'prayer-room',
            'section' => 'features',
            'key' => 'feature_community',
            'title' => 'Community Prayer',
            'content' => 'Join believers worldwide in united prayer for nations, churches, and global concerns.',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // Scripture Section
        PageContent::create([
            'page' => 'prayer-room',
            'section' => 'scripture',
            'key' => 'scripture_title',
            'title' => 'Daily Scripture Focus',
            'content' => 'Let these words guide your prayer time today',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'prayer-room',
            'section' => 'scripture',
            'key' => 'scripture_quote',
            'title' => 'Prayer Scripture',
            'content' => '"Pray without ceasing. In everything give thanks: for this is the will of God in Christ Jesus concerning you."',
            'subtitle' => '1 Thessalonians 5:17-18 (KJV)',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // Guide Section
        PageContent::create([
            'page' => 'prayer-room',
            'section' => 'guide',
            'key' => 'guide_title',
            'title' => 'Your Prayer Guide',
            'subtitle' => 'Simple steps to enrich your prayer experience',
            'content' => 'Simple steps to enrich your prayer experience',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'prayer-room',
            'section' => 'guide',
            'key' => 'guide_step_1',
            'title' => 'Prepare Your Heart',
            'content' => 'Find a quiet place, center your thoughts, and approach God with reverence and expectation.',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'prayer-room',
            'section' => 'guide',
            'key' => 'guide_step_2',
            'title' => 'Express Gratitude',
            'content' => 'Begin with thanksgiving, acknowledging God\'s goodness and faithfulness in your life.',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'prayer-room',
            'section' => 'guide',
            'key' => 'guide_step_3',
            'title' => 'Share Your Heart',
            'content' => 'Pour out your requests, concerns, and praises honestly before your Heavenly Father.',
            'sort_order' => 4,
            'is_active' => true,
        ]);
    }

    private function createStreamPageContent()
    {
        // Hero Section
        PageContent::create([
            'page' => 'stream',
            'section' => 'hero',
            'key' => 'hero_title',
            'title' => 'Live Streaming',
            'subtitle' => 'Watch live events and past recordings',
            'content' => 'Experience powerful worship and teaching sessions from the comfort of your home.',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }

    private function createRadioPageContent()
    {
        // Hero Section
        PageContent::create([
            'page' => 'radio',
            'section' => 'hero',
            'key' => 'hero_title',
            'title' => 'ISM Prayer Radio',
            'subtitle' => '24/7 spiritual guidance and prayer broadcasts',
            'content' => 'Tune in to our 24/7 prayer radio for continuous worship, teaching, and intercession.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Login Required Section
        PageContent::create([
            'page' => 'radio',
            'section' => 'login',
            'key' => 'login_title',
            'title' => 'Access Required',
            'content' => 'Please log in to access our 24/7 prayer radio broadcasts',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }

    private function createGroupsPageContent()
    {
        // Hero Section
        PageContent::create([
            'page' => 'groups',
            'section' => 'hero',
            'key' => 'hero_title',
            'title' => 'Prayer Groups',
            'subtitle' => 'Connect, Pray, and Grow Together',
            'content' => 'Find or create a prayer group in your area and experience the power of united prayer.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Features Section
        PageContent::create([
            'page' => 'groups',
            'section' => 'features',
            'key' => 'features_title',
            'title' => 'Why Join a Prayer Group?',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'groups',
            'section' => 'features',
            'key' => 'feature_fellowship',
            'title' => 'Christian Fellowship',
            'content' => 'Build meaningful relationships with other believers who share your passion for prayer.',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'groups',
            'section' => 'features',
            'key' => 'feature_accountability',
            'title' => 'Spiritual Accountability',
            'content' => 'Grow in your faith journey with the support and encouragement of like-minded intercessors.',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        PageContent::create([
            'page' => 'groups',
            'section' => 'features',
            'key' => 'feature_impact',
            'title' => 'Greater Impact',
            'content' => 'Multiply your prayer impact by joining forces with others who are interceding for the same causes.',
            'sort_order' => 4,
            'is_active' => true,
        ]);
    }

    private function createTestimoniesPageContent()
    {
        // Hero Section
        PageContent::create([
            'page' => 'testimonies',
            'section' => 'hero',
            'key' => 'hero_title',
            'title' => 'Testimonies',
            'subtitle' => 'God is Working!',
            'content' => 'Read amazing stories of how God is moving through prayer in the lives of our community members.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // CTA Section
        PageContent::create([
            'page' => 'testimonies',
            'section' => 'cta',
            'key' => 'cta_title',
            'title' => 'Share Your Testimony',
            'content' => 'Have you experienced God\'s power through prayer? We\'d love to hear your story!',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }

    private function createNewsPageContent()
    {
        // Hero Section
        PageContent::create([
            'page' => 'news',
            'section' => 'hero',
            'key' => 'hero_title',
            'title' => 'News & Updates',
            'subtitle' => 'Stay Informed',
            'content' => 'Keep up with the latest news, announcements, and updates from ISM Ministers Prayer Network.',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }

    private function createEventsPageContent()
    {
        // Hero Section
        PageContent::create([
            'page' => 'events',
            'section' => 'hero',
            'key' => 'hero_title',
            'title' => 'Upcoming Events',
            'subtitle' => 'Join Us In-Person or Online',
            'content' => 'Discover and participate in upcoming prayer events, conferences, and worship gatherings.',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }
}