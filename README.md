## Project Documentation for hGifts
### Overview
The hGifts project is a web application that allows users to create and manage their own gift lists. It is built using the Vue.js framework and utilizes the Vuex state management pattern for managing the application's state. This documentation aims to provide an overview of the project structure, installation process, and key features.
This is built using Laravel 8 for the backend and vue.js options  API for the front-end. Native or modified native components can have composition API too. 

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
The project follows the MVC architecture pattern. Is build with Laravel for the backend, and vue.js for the front-end. This is a full-stack web application. 
The project structure follows a standard Vue.js application structure. Here is an overview of the key directories and files:
- `src`: Contains the main source code of the application.
  - `assets`: Contains static assets such as images and CSS files.
  - `components`: Contains Vue components used throughout the application.
  - `router`: Contains the Vue Router configuration for defining application routes.
  - `store`: Contains the Vuex store configuration and modules for managing application state.
  - `views`: Contains the main views of the application, each representing a separate page.
  - `App.vue`: The main Vue component serving as the entry point of the application.
  - `main.js`: The JavaScript file that initializes and mounts the Vue application.
### Vuex Implementation
Vuex is used in the hGifts project to manage the application's state and enable efficient communication between components. The Vuex implementation consists of the following key elements:
- **State**: The application's state is stored in a central store object. It includes properties such as `user` for storing user information and `gifts` for managing gift data.
- **Mutations**: Mutations are responsible for modifying the state. They are synchronous functions that receive the current state and payload as arguments and make changes to the state as needed.
- **Actions**: Actions are used to perform asynchronous operations and commit mutations. They can dispatch multiple mutations or actions to update the state and handle side effects.
- **Getters**: Getters are used to derive computed properties from the state. They are similar to computed properties in Vue components and can be accessed using `this.$store.getters`.
### Key Features
The hGifts application offers several key features to manage gift lists. Here are some of the main features:
- **User Authentication**: Users can sign up and log in to the application to create and manage their gift lists. The authentication functionality is implemented using Firebase authentication.
- **Gift Creation and Management**: Users can add new gifts to their lists, edit existing gifts, and mark gifts as purchased. The gift data is stored in the Vuex store and updated in real-time.
- **Roles and Permissions**: There are mainly 2 roles. The admin role and the normal user role. Normal user role can view the campaigns where he's subscribed, or that are currently active (have not been deilvered yet). Admin role, can see all campaigns, add and delete roles from users,  remove and add items. 
- **Comment and Rating**: Each User can comment and rate the campaign where he's been linked to. Providing valuable feedback for future campaigns. 
- **Courier information**: This app also includes a PDF download button, which provides with a list of users and addresses that are subscribed to certain campagin. Therefore, they can use it for 
## Conclusion
This documentation provides an overview of the hGifts project, including installation instructions, project structure, Vuex implementation, and key features. By following the provided steps, users can set up the project locally and start exploring its functionality.
