
# Technical Report for ISM Ministers Prayer Network

## 1. Introduction

This report provides a technical overview of the ISM Ministers Prayer Network web application. The application is built on the Laravel framework and is designed to facilitate a global network of ministers in prayer.

## 2. System Architecture

The application follows a standard Model-View-Controller (MVC) architecture, which is inherent to the Laravel framework. This separation of concerns allows for a clear and organized codebase.
- **Model**: Represents the data structure and business logic of the application. These are located in the `app/Models` directory.
- **View**: The user interface of the application, which is rendered using Laravel's Blade templating engine. These files are located in the `resources/views` directory.
- **Controller**: Handles user requests and interacts with the Model and View. These are located in the `app/Http/Controllers` directory.

## 3. Features and Pages

The application offers a comprehensive suite of features, segmented for public users, registered members, and administrators.

### Public-Facing Features
These features are accessible to all visitors of the website.
- **Homepage**: Displays an overview of the ministry, recent news, and upcoming events.
- **About Us**: Provides detailed information about the ISM Ministers Prayer Network.
- **Prayer Wall**:
    - Public users can submit prayer requests through a form.
    - View a feed of prayer requests and testimonies.
- **Testimonies**:
    - Users can submit their testimonies.
    - Browse a collection of shared testimonies.
- **Programs**: View a list of ministry programs and their detailed descriptions.
- **News**: Read articles and updates from the ministry.
- **Events**: Browse a calendar of upcoming events.
- **Resource Centers**:
    - **Prayer Resources**: Access and download prayer-related materials.
    - **Video Resources**: Watch a collection of ministry videos.
    - **Worship Music**: Listen to a curated list of worship songs.
- **Coordinators**: Find and view a directory of regional coordinators.
- **Media**:
    - **Live Stream**: Watch live broadcasts of events.
    - **Online Radio**: Listen to the ministry's online radio station.
- **Groups Directory**: Browse and search for public prayer groups.
- **Contact Page**: A form to send messages and inquiries to the administration.
- **Newsletter Subscription**: A form for users to subscribe to the newsletter.
- **Search**: A global search functionality to find content across the site.

### Member-Specific Features (Account Required)
These features require users to register and log in.
- **Authentication**: Secure user registration, login, and password management.
- **Profile Management**:
    - View and update personal profile information (name, designation, mobile).
    - Upload and change a profile picture.
    - Change account password.
- **Group Management**:
    - **Create Groups**: Members can create their own prayer groups.
    - **My Groups**: View a list of groups the member has created or joined.
    - **Join/Leave Groups**: Functionality to join public groups and leave them.
- **Interactive Group Features**:
    - **Group Dashboard**: A central hub for each group, showing details and activity.
    - **Group Chat/Discussions**: A real-time chat or forum for group members to communicate.
    - **Group Settings**: For group owners to manage group details, rules, and members.
    - **Content Sharing**:
        - Post and manage group-specific events.
        - Upload and share photos within the group.
        - Share resources (documents, links) with group members.

### Administrative Panel
A secure backend interface for site administrators.
- **Dashboard**: Provides an overview and statistics of the website's activity.
- **User Management**: Full CRUD (Create, Read, Update, Delete) functionality for all users, including the ability to grant/revoke admin privileges.
- **Content Management (Full CRUD)**:
    - **Programs**: Manage ministry programs.
    - **News**: Create and manage news articles.
    - **Testimonies**: Approve and manage user-submitted testimonies.
    - **Coordinators**: Manage the directory of coordinators.
    - **Worship Music**: Manage the music playlist.
- **Media Management (Full CRUD)**:
    - **Live Streams**: Manage stream schedules and details.
    - **Radio**: Manage radio schedules and content.
    - **Prayer Resources**: Upload and manage downloadable resources.
    - **Video Resources**: Upload and manage the video library.
- **Group Administration**: Full CRUD functionality for all groups on the platform.

## 4. Database Schema

The database schema is defined using Laravel's migration files, located in the `database/migrations` directory. The key tables in the database are:

- **users**: Stores user information.
  - `id`: Primary key.
  - `name`: User's full name.
  - `email`: User's email address (unique).
  - `email_verified_at`: Timestamp for email verification.
  - `password`: Hashed password.
  - `image`: Profile picture.
  - `designation`: User's designation or title.
  - `mobile`: User's mobile number.
  - `remember_token`: For 'remember me' functionality.
  - `timestamps`: `created_at` and `updated_at` timestamps.

- **groups**: Stores information about prayer groups.
  - `id`: Primary key.
  - `title`: The name of the group.
  - `country`: The country where the group is located.
  - `city`: The city where the group is located.
  - `address`: The physical address of the group.
  - `description`: A description of the group.
  - `max_members`: The maximum number of members allowed in the group.
  - `current_members`: The current number of members in the group.
  - `category_id`: Foreign key referencing the `categories` table.
  - `group_type_id`: Foreign key referencing the `group_types` table.
  - `user_id`: Foreign key referencing the `users` table (the group creator).
  - `timestamps`: `created_at` and `updated_at` timestamps.

## 5. Frontend Dependencies

The frontend of the application is built using Laravel's Blade templating engine, with Vite for asset bundling. The key frontend dependencies are:

- **axios**: A promise-based HTTP client for the browser and Node.js.
- **laravel-vite-plugin**: The official Laravel plugin for Vite.
- **vite**: A modern frontend build tool that provides a faster and leaner development experience.

## 6. Backend Dependencies

The backend is powered by PHP and the Laravel framework. The key Composer dependencies are:

- **php**: The application requires PHP version 8.1 or higher.
- **guzzlehttp/guzzle**: A PHP HTTP client that makes it easy to send HTTP requests.
- **intervention/image**: A PHP image handling and manipulation library.
- **laravel/framework**: The core Laravel framework.
- **laravel/sanctum**: A lightweight authentication system for SPAs (single page applications), mobile applications, and simple, token based APIs.
- **laravel/tinker**: An interactive REPL for the Laravel framework.

## 7. Routing

The application's routes are defined in the `routes/web.php` file. The routes are organized into several groups:

- **Public Routes**: These are accessible to all users and include pages like the homepage, about page, contact page, and event listings.
- **Authentication Routes**: These routes handle user registration, login, and logout.
- **Authenticated Routes**: These routes are only accessible to logged-in users and include features like user profiles, group creation, and group management.
- **Admin Routes**: These routes are for administrative purposes and are protected by an admin authentication middleware. They allow for the management of users, groups, and other application settings.

## 8. Security

The application implements several security measures to protect against common vulnerabilities:

- **Cross-Site Request Forgery (CSRF) Protection**: Laravel's built-in CSRF protection is used to prevent malicious exploits.
- **SQL Injection Prevention**: The Eloquent ORM uses parameter binding to protect against SQL injection attacks.
- **Cross-Site Scripting (XSS) Protection**: Laravel's Blade templating engine automatically escapes HTML entities to prevent XSS attacks.
- **Password Hashing**: User passwords are securely hashed using bcrypt.
- **Authentication**: The application uses Laravel's built-in authentication system to manage user sessions and protect routes.

## 9. Conclusion

The ISM Ministers Prayer Network is a robust and secure web application that provides a platform for ministers to connect and pray together. The use of the Laravel framework provides a solid foundation for the application, and the separation of concerns in the MVC architecture makes the codebase easy to maintain and extend.
