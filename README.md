## Project Documentation for hGifts
### Overview
The hGifts project is a web application that allows your company, to manage the logistic of your employee's gift campaigns. It is built using the Vue.js framework and utilizes the Vuex state management pattern for managing the application's state. This documentation aims to provide an overview of the project structure, installation process, and key features.
This is built using Laravel 8 for the backend and vue.js options  API for the front end. Native or modified native components can have composition API too. 

The name  hGifts comes as a project built for Hostinger as a development task. 

### Installation
To set up the hGifts project locally, follow the steps below:
1. Clone the repository from GitHub using the following command:
   ```
   git clone https://github.com/maalzates/hgifts.git
   ```
2. Navigate to the project directory:
   ```
   cd hgifts
   ```
3. Install the project dependencies:
   ```
   npm install
   ```
4. Run the development server:
   ```
   npm run serve
   ```
5. Access the application in your browser at `http://localhost:8080`.
### Project Structure
The project follows the MVC architecture pattern. Is built with Laravel for the backend, and vue.js for the front-end. This is a full-stack web application. 
The project structure follows a standard Laravel application file structure. 
Routing is made using Laravel routes/web.php and routes/api.php 
Also, for SPA we used native Laravel inertia components such as the Link component. 

### Vuex Implementation
Vuex is used in the hGifts project to manage the application's state and enable efficient communication between components. The Vuex implementation consists of the following key elements:
- **State**: The application's state is stored in a central store object. It includes properties such as `user` for storing user information and `gifts` for managing gift data.
- **Mutations**: Mutations are responsible for modifying the state. They are synchronous functions that receive the current state and payload as arguments and make changes to the state as needed.
- **Actions**: Actions are used to perform asynchronous operations and commit mutations. They can dispatch multiple mutations or actions to update the state and handle side effects.
- **Getters**: Getters are used to derive computed properties from the state. They are similar to computed properties in Vue components and can be accessed using `this.$store.getters`.
### Key Features
The hGifts application offers several key features to manage gift lists. Here are some of the main features:
- **User Authentication**: Users can sign up and log in to the application to manage their gift campaign subscriptions. The authentication functionality is implemented using Laravel Sanctrum authentication. 
- **Gift Creation and Management**: Users can subscribe or unsubscribe to campaign lists. Admin roles can edit, create or modify all related, which includes, gift box content, and subscribed users for each campaign, and create modify, or delete new items. The gift data is stored in the Vuex store and updated in real-time.
- **Roles and Permissions**: The roles are implemented using the laravel package Spatie. There are mainly 2 roles. The admin role and the normal user role. Normal user role can view the campaigns where he's subscribed, or that are currently active (have not been delivered yet). Admin role, can see all campaigns, add and delete roles from users,  and remove and add items. 
- **Comment and Rating**: Each User can comment and rate the campaign to which he's been linked. Providing valuable feedback for future campaigns. 
- **Courier information**: This app also includes a PDF download button, which provides a list of users and addresses that are subscribed to certain campaign. Therefore, they can use it for delivering gifts to each employee.

### Styling
The styles are built using the native template of Laravel jetstream and customized using Tailwind resulting in a smooth and beautiful interface. 

## Conclusion
This documentation provides an overview of the hGifts project, including installation instructions, project structure, Vuex implementation, and key features. By following the provided steps, users can set up the project locally and start exploring its functionality.
