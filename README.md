# Laravel Chat Application

This is a Laravel-based chat application that provides real-time messaging functionality with support for chatrooms, user authentication, and media attachments.

# For the demo live (example)

`whatsapp-clone-seven-neon.vercel.app`

Because this uses the free Vercel demo server, you may encounter some errors, such as limited storage access, then error problems like
Method Laravel\Lumen\Http\ResponseFactory::view does not exist, that's because of server limitations which can't access storage which in Laravel is very important, I've tried to update the setup but you can't expect much. therefore I highly recommend running manually using the procedures I mentioned below.

## Table of Contents

1. [Installation](#installation)
2. [Access and Usage](#access-and-usage)
3. [Routes and Controllers](#routes-and-controllers)
   - [Authentication Routes](#authentication-routes)
   - [Chatroom Routes](#chatroom-routes)
   - [Message Routes](#message-routes)
5. [Detailed API Guide](#detailed-api-guide)

---

## Installation

1. **Clone the Repository**:
    ```bash
    git clone <repository-url> whatsapp-clone
    cd whatsapp-clone
    ```

2. **Install Dependencies**:
    Ensure you have `composer` installed, then run:
    ```bash
    composer install
    ```

3. **Set Up Environment**:
    - Duplicate `.env.example` to `.env`.
    - Set up the database connection, Pusher credentials, and other environment-specific values.

4. **Generate Application Key**:
    ```bash
    php artisan key:generate
    ```

5. **Run Migrations**:
    ```bash
    php artisan migrate
    php artisan db:seed
    ```

6. **Start the Server**:
    ```bash
    php artisan serve
    php artisan queue:work
    ```
7. **pusher credential**:
    ```bash
    PUSHER_APP_ID=1891238
    PUSHER_APP_KEY=405a4e9cb8d5939e8833
    PUSHER_APP_SECRET=b9957d7caea7df495934
    PUSHER_APP_CLUSTER=ap1
    ```

## Access and Usage

The application can be accessed via `http://localhost:8000` once the server is running.

### Public Routes

- **Home**: `/`
- **Login**: `/login`

### Protected Routes

These routes require user authentication:

- Chatroom and messaging functionalities require the user to be logged in.

---

## Routes and Controllers

### Authentication Routes

| Route     | Method | Controller      | Description                     |
|-----------|--------|------------------|---------------------------------|
| `/login`  | GET    | AuthController    | Display login form              |
| `/login`  | POST   | AuthController    | Authenticate the user           |
| `/logout` | POST   | AuthController    | Log out the user                |

**AuthController** handles user authentication, including login and logout.

### Chatroom Routes

| Route                       | Method | Controller        | Description                     |
|-----------------------------|--------|-------------------|---------------------------------|
| `/chatrooms`                | GET    | ChatroomController | List all chatrooms              |
| `/chatrooms/{id}`           | GET    | ChatroomController | Display specific chatroom       |
| `/chatrooms`                | POST   | ChatroomController | Create a new chatroom           |
| `/chatrooms/{id}/enter`     | GET    | ChatroomController | Enter a specific chatroom       |
| `/chatrooms/{id}/leave`     | GET    | ChatroomController | Leave a specific chatroom       |

**ChatroomController** manages chatroom creation, listing, and user interactions within chatrooms.

### Message Routes

| Route                                    | Method | Controller       | Description                   |
|------------------------------------------|--------|-------------------|-------------------------------|
| `/chatrooms/{chatroomId}/messages`      | GET    | MessageController | List all messages in chatroom |
| `/chatrooms/{chatroomId}/messages`      | POST   | MessageController | Send a message                |

**MessageController** handles sending and listing messages in a chatroom.

---

## Detailed API Guide

### Authentication

#### Login (POST `/login`)

- **Info**:
  - You can look at UsersTableSeeder to see the credentials for logging in or you can try user1@example.com and for the password is `password123`.

- **Parameters**:
  - `email` (string, required) 
  - `password` (string, required)

- **Response**:
  - **Success**: Redirect to chatroom view.
  - **Failure**: Returns error message for invalid credentials.

#### Logout (POST `/logout`)

- Logs the user out and redirects to the login screen.

---

### Chatroom Management

#### List Chatrooms (GET `/chatrooms`)

- **Description**: Retrieves all available chatrooms.

- **Response**:
  - JSON array of all chatrooms with details.

#### Create Chatroom (POST `/chatrooms`)

- **Parameters**:
  - `name` (string, required): Name of the chatroom.
  - `max_members` (integer, required): Maximum number of members.

- **Response**:
  - JSON object with the created chatroom's data.

#### Enter Chatroom (GET `/chatrooms/{id}/enter`)

- **Description**: Allows a user to enter a specific chatroom if not full.

- **Response**:
  - **Success**: JSON message confirming entry.
  - **Failure**: Error if the chatroom is full or the user is already a member.

#### Leave Chatroom (GET `/chatrooms/{id}/leave`)

- **Description**: Allows a user to leave a chatroom.

- **Response**:
  - **Success**: JSON message confirming user left the chatroom.
  - **Failure**: Error if the user is not a member of the chatroom.

---

### Messaging

#### List Messages (GET `/chatrooms/{chatroomId}/messages`)

- **Description**: Lists all messages within a specific chatroom.

- **Response**:
  - JSON array of messages, each including user ID, content, and timestamp.

#### Send Message (POST `/chatrooms/{chatroomId}/messages`)

- **Parameters**:
  - `chatroom_id` (integer, required): ID of the chatroom.
  - `user_id` (integer, required): ID of the sender.
  - `content` (string, optional): Message text content.
  - `attachment` (file, optional): File attachment (image/video).

- **Response**:
  - JSON object with message details, including file URL if an attachment is provided.
