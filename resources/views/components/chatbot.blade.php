<!-- /**
 * Project: PSTC-Kalinga Innovation, Setup & Project Locator
 * Author: Karl Jasper G. Del Rosario
 * Date: June 2025
 * Description:  This project visualizes DOST project locations in Kalinga using a map-based interface.
 */
  -->
 
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"> <!-- Google Fonts Link for Icons -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
        * {
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
                html {
            touch-action: manipulation;
            -ms-touch-action: manipulation; 
        }
        @keyframes popInOut {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.-); } 
        }
        @keyframes popEffect {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        .chatbot-toggler {
            overflow: auto;
            position: fixed;
            right: 75px;
            bottom: 75px;
            height: 70px;
            width: 70px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            outline: none;
            cursor: pointer;
            background: #4CC9FE;
            border-radius: 50%;
            transition: all 0.2s ease;
            z-index: 2;
            border: 2px solid rgb(0, 0, 0);
            padding: 0;
            animation: popEffect 1.5s infinite ease-in-out;
        }
        .chatbot-toggler img.toggler-img {
            width: 50px; 
            height: 50px;
            object-fit: contain;
            transition: transform 0.2s ease;
        }
        .show-chatbot .chatbot-toggler {
            transform: rotate(90deg);
        }
        .show-chatbot .toggler-img {
            transform: rotate(180deg); 
        }
        @keyframes tooltipEffect {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }
        .chatbot-description {
            animation: tooltipEffect 5s infinite;
        }
        .chatbot{
            position: fixed;
            right:70px;
            bottom: 50px;
            width: 440px;
            max-height: 740px;
            height: 740px;
            transform: scale(0.5);
            opacity: 0;
            pointer-events: none;
            overflow: hidden;
            background: #fff;
            border-radius: 15px;
            transform-origin: bottom right;
            box-shadow: 0 0 128 px 0 rgba(0,0,0,0.1),
                        0 32px 64px -48px rgba(0,0,0,0.5);
            transition: all 0.1s ease;
            z-index: 3;
            border: 2px solid rgb(0, 0, 0);
        }
        .chatbot-description {
            position: fixed;
            right: 130px;
            bottom: 130px;
            transform: translateX(50%);
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            z-index: 3;
        }
        .show-chatbot .chatbot{
            transform: scale(1);
            opacity: 1;
            pointer-events: auto;
        }
        .chatbot header{
            color: white;
            background:rgb(0, 0, 0);
            padding: 14px;
            text-align: center;
            display: flex;
            height: 90px;
        }
        .chatbot header h2 {
            color: #FFFFFF;
            font-size: 1.4rem;
        }
        .chatbot header span {
            position: absolute;
            right: 30px;
            top: 6%;
            color: #FFFFFF;
            cursor: pointer;
            display: block;
            transform: translateY(-50%);
        }
        .header-text-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center; 
        }
        .header-text {
            font-size: 15px; 
            font-weight: bold;
            color: white;
            margin: 0; 
        }
        .header-text2 {
            font-size: 30px; 
            font-weight: bold;
            color: white;
            margin: 0; 
            margin-left: 25px;
            text-align: left;
        }
        .header::after {
            content: '';
            position: absolute;
            bottom: -20px; 
            left: 0;
            width: 100%;
            height: 40px; 
            background: #4CC9FE; 
            border-radius: 50% 50% 0 0;
        }
        .chatbot .chatbox {
            height: 610px;
            overflow-y: auto;
            padding: 30px 20px 100px;
        }
        .chatbot .chat {
            display: flex;
        }
        .chatbot .incoming span{
            height: 32px;
            width: 32px;
            color: #fff;
            align-self: flex-end;
            background: #4CC9FE;
            text-align:center;
            line-height: 32px;
            border-radius: 4px;
            margin: 0 10px 0;
        }
        .chatbot .outgoing {
            margin: 20px 0;
            justify-content: flex-end;
            position: relative;
        }
        .chatbot .outgoing p {
            margin-top: 30px;
            font-weight: bold;
            position: relative;
            color: black;
            max-width: 75%;
            font-size: 0.95rem;
            white-space: pre-wrap;
            background: #4CC9FE;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .chatbot .outgoing p::before {
            content: "";
            position: absolute;
            top: 0;
            right: -10px;
            width: 0;
            height: 0;
            border-bottom: 10px solid transparent;
            border-left: 10px solid #4CC9FE;
        }
        .chatbot .chat p {
            max-width: 75%;
            font-size: 0.95rem;
            white-space: pre-wrap;
            padding: 12px 16px;
            border-radius: 10px 0 10px 10px;
            background: linear-gradient(to right, #4CC9FE, #12D8FA,  #4CC9FE, #12D8FA);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .chatbot .chat p.error {
        color: #721c24;
            background: #f8d7da;
        }
        .chatbot .incoming p {
            color: white;
            margin-top: 10px;
            position: relative;
            color: #000;
            background:rgb(255, 255, 255);
            border: 1px solid black;
            border-radius: 0 10px 10px 10px;
            width: 360px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .chatbot .incoming p::before {
            content: "";
            position: absolute;
            top: -1px;
            left: -10px;
            width: 0;
            height: 0;
            border-bottom: 10px solid transparent;
            border-right: 10px solid rgb(0, 0, 0);
        }
        .chatbot .chat-input{
            position: absolute;
            bottom: 0;
            width: 100%;
            display: flex;
            gap: 5px;
            background: #fff;
            align-items: flex-end;
            padding: 5px 20px;
            border-top: 1px solid #ccc;
        } 
        .chat-input textarea {
            height: 55px;
            width: 100%;
            max-height: 180px;
            overflow: hidden;
            border: none;
            outline: none;
            font-size: 0.95rem;
            resize: none;
            padding: 16px 15px 16px 0;
        }
        .chat-input span{
            align-self: flex-end;
            height: 55px;
            line-height: 55px;
            color:rgba(58, 0, 231, 0.9);
            font-size: 1.35em;
            cursor: pointer;
            visibility: hidden;
        }
        .chat-input textarea:valid ~ span{
            visibility: visible;
        }
        .chat .dialog-options {
            display: flex;
            gap: 5px;
            padding: 5px;
            background: #fff;
            flex-wrap: wrap;
            justify-content: center;
            bottom: 0;
            width: 100%;
        }
        .chat .dialog-options button {
            color: black;
            font-weight: bold;
            border: 1px solid black;
            background: linear-gradient(to right, #4CC9FE, #12D8FA,  #4CC9FE, #12D8FA);
            border-radius: 25px;
            padding: 8px 12px;
            cursor: pointer;
        }
        .chat .dialog-options button:hover {
            background: rgb(118, 191, 223);
        }
        .chat-icon{
            min-width: 40px; 
            display: flex;
            justify-content: center;
        }
        .chat-icon img {
            width: 30px;
            height: 30px; 
            margin-left: -10px;
            object-fit: contain;
        }
        .header-icon-wrapper {
            width: 60px; 
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white; 
            border: 2px solid rgb(255, 255, 255); 
            border-radius: 50%;
        }
        .header-icon {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .chatbot header .minimize-btn {
            margin: 0;
            right: 70px; 
            top: 20px;
        }
        .minimize-btn:hover {
            color: #ff9800;
        }
        .chatbot header .close-btn {
            background-color: black;
            top: 27px;
            margin-left: 10px;
            font-family: 'Material Symbols Outlined', sans-serif;
            font-size: 24px;
            cursor: pointer;
            transition: color 0.3s ease, transform 0.2s ease;
            padding: 5px;
            border-radius: 50%;
        }
        .send-btn {
            font-size: 55;
        }
        .close-btn:hover {
            color: #ff3b30; 
        }
        .close-btn:active {
            color: #d32f2f; 
        }
        
 @keyframes scroll_4013 {
    0% {
        transform: translateY(40%);
    }
    50% {
        transform: translateY(90%);
    }
    100% {
        transform: translateY(40%);
    }
}
        .element {
            animation: scroll_4013 3s ease-in-out infinite;
        }
        .chatbox::-webkit-scrollbar {
            width: 5px; 
            height: 10px; 
        }
        .chatbox::-webkit-scrollbar-thumb {
            background-color: rgb(60, 62, 77); 
            border-radius: 10px; 
            box-shadow: 0px 0px 10px rgb(43, 45, 54); 
        }
        .chatbox::-webkit-scrollbar-thumb:hover {
            background-color: rgb(51, 52, 56); 
        }
        .chatbox::-webkit-scrollbar-track {
            background-color: rgba(105, 127, 255, 0.2); 
            border-radius: 10px; 
        }
        .chatbox::-webkit-scrollbar-track-piece {
            background-color: transparent; 
        }
        .custom-shape-divider-bottom-1743647769 {
            position: absolute;
            display: block;
            left: 0;
            width: 100%;
            overflow: hidden;
            z-index: 999;
        }
        .custom-shape-divider-bottom-1743647769 svg {
            position: relative;
            display: block;
            width: calc(179% + 1.3px);
            height: 30px;
            transform: rotateY(180deg);
            z-index: 999;
        }
        .custom-shape-divider-bottom-1743647769 .shape-fill {
            fill:rgb(0, 0, 0) ; 
            z-index: 999;
        }
        .green-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color:rgb(0, 255, 64);
        border-radius: 50%;
        margin-right: 337px;
        margin-top: 25px;
        vertical-align: middle;
        }
        #send-btn {
        font-size: 32px;
        }

        .chatbot.minimized {
            height: 0;
    overflow: hidden;
    opacity: 0;
    transform: scaleX(0);
    transform-origin: left right;
    transition: all 0.3s ease;
        }
        /* From Uiverse.io by Zain-Muhammad */ 
.tooltip-wrapper {
    margin-right: 385px;
    margin-top: -70px;
  --clr-btn: #000000;;
  --clr-dropdown: rgb(2 22 36);
  --clr-nav-hover: rgb(2 22 36);
  --clr-dropdown-hov: rgb(2 22 36);
  --clr-dropdown-link-hov: rgb(2 22 36);
  --clr-light: #ffffff;
}
.nav-link {
  position: relative;
}
.tooltip-wrapper > .tooltip-container {
  display: flex;
  justify-content: space-around;
  align-items: center;
}
.tooltip-container,
.tooltip-menu-with-icon {
  list-style: none;
}
.nav-link > .tooltip-tab {
  color: var(--clr-light);
  background: var(--clr-btn);
  padding: 0.5rem 0.5rem;
  letter-spacing: 1px;
  font-size: 0.75rem;
  display: flex;
  align-items: center;
  column-gap: 12px;
  justify-content: space-between;
  text-transform: uppercase;
  cursor: pointer;
  border: 1px solid #00c1d5;
  transition: 0.3s ease-in-out;
}
.nav-link > .tooltip-tab:hover svg {
  transform: rotate(360deg);
  transition: 0.3s ease-in-out;
}
.tooltip-links {
  text-decoration: none;
}
.nav-link svg {
  fill: #fff;
}
.tooltip {
  position: absolute;
  bottom: 100%;
  left: 0;
  min-width: 12rem;
  max-width: 15rem;
  transform: translateY(-10px);
  opacity: 0;
  pointer-events: none;
  transition: 0.5s;
  padding: 0px 0px 15px 0px;
}

.tooltip::after {
  content: "";
  width: 15px;
  height: 15px;
  background: #00c1d5 no-repeat -30px -50px fixed;
  bottom: 0;
  left: 6%;
  position: absolute;
  display: inline-block;
  clip-path: polygon(50% 100%, 0% 0%, 100% 0%);
  transform: rotate(180deg);
  z-index: -1;
  box-shadow: 0px -6px 30px rgb(2 22 36); 
}

.tooltip .tooltip-menu-with-icon {
  padding: 10px 0px;
  background-color: var(--clr-dropdown);
  border: 1px solid #00c1d5;
  position: relative;
}
.tooltip-link {
  position: relative;
}
.tooltip-link:not(:nth-last-child(2)) {
  border-bottom: 1px solid var(--clr-dropdown);
}
.tooltip-link > a {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  column-gap: 10px;
  background-color: var(--clr-dropdown);
  color: var(--clr-light);
  padding: 0.5rem 1rem;
  font-size: 0.75rem;
  transition: 0.3s;
}
.tooltip-menu-with-icon svg {
  height: 20px;
  margin-left: 0px;
}
.nav-link:hover > .tooltip-tab {
  transform: scale(1.1);
}
.nav-link:hover > .tooltip,
.tooltip-link:hover > .tooltip {
  transform: translate(0, 0);
  opacity: 1;
  pointer-events: auto;
  -webkit-transform: translate(0, 0);
  -moz-transform: translate(0, 0);
  -ms-transform: translate(0, 0);
  -o-transform: translate(0, 0);
}
.nav-link:hover > .tooltip-tab {
  transform: scale(1);
  background-color: var(--clr-nav-hover);
}

    </style>
</head>

<body>

    <div class="chatbot-description">Click me!</div>

        <button class="chatbot-toggler">
            <img class="toggler-img" src="{{ asset('images/DOST.png') }}" alt="Chatbot Toggler">
        </button>

        <ul class="chatbot">
            <header>
                <div class="header-icon-wrapper">
                    <img class="header-icon" src="{{ asset('images/DOST.png') }}" alt="Header Icon">
                </div>

                <div class="header-text-wrapper">
                <p class="header-text2">CHATBOT</p>
                    <p class="header-text">Department of Science and Technology</p>
                    <span class="green-dot"></span>
               
                </div>
                
                <span class="close-btn material-symbols-outlined">close</span>

                <span class="minimize-btn material-symbols-outlined">minimize</span>
            
            </header>
            <div class="custom-shape-divider-bottom-1743647769">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
                    <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
                    <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
                </svg>
            </div>
            <ul div class="chatbox">        
        </ul>
        
        <div class="chat-input">
            <textarea placeholder="Enter a message..." required></textarea>
            <span id="send-btn" class="material-symbols-outlined">send</span>
            

    </div>
    <div class="dialog-options" style="display: none; height: 0%; overflow: hidden;"></div>

</body>

<script>
    const chatInput = document.querySelector(".chat-input textarea");
    const sendChatBtn = document.querySelector(".chat-input span");
    const chatbox = document.querySelector('.chatbox');
    const dialogOptions = document.querySelector('.dialog-options');
    const chatbotToggler = document.querySelector(".chatbot-toggler");
    const chatbotCloseBtn = document.querySelector(".close-btn");
    const chatTextarea = document.querySelector(".chat-input textarea");
    const minimizeBtn = document.querySelector('.minimize-btn');
const chatbot = document.querySelector('.chatbot');

let isMinimized = false;

const createChatLi = (message, className) => {
//Create a chat <li> element with passed message and className
const chatLi = document.createElement("li");
chatLi.classList.add("chat", className);
let chatContent = className === "outgoing" ? `<p>${message}</p>` : `<span class="material-symbols-outlined">smart_toy</span><p>${message}</p>`;
chatLi.innerHTML = chatContent;
chatLi.querySelector("p").textContent = message;
return chatLi;
}

const dialogFlow = {
    start: {
        message: "Hello! I'm the PSTC-Kalinga DOST Chatbot. Welcome to the Provincial Science and Technology Center of Kalinga! How can I help you today?",
        options: [
            { label: "About PSTC-Kalinga DOST", next: "about_pstc" },
            { label: "Our Services & Programs", next: "services" },
            { label: "Equipment & Facilities", next: "equipment" },
            { label: "Contact Information", next: "contact" }
        ]
    },
    
    about_pstc: {
        message: "PSTC-Kalinga is the Provincial Science and Technology Center under the Department of Science and Technology (DOST). We serve as the regional hub for science and technology innovation in Kalinga Province, supporting local communities, researchers, and entrepreneurs.",
        options: [
            { label: "Our Mission & Vision", next: "mission_vision" },
            { label: "Location & Coverage Area", next: "location" },
            { label: "Our Team", next: "team" },
            { label: "Back to Main Menu", next: "start" }
        ]
    },

    mission_vision: {
        message: "Our Vision: Excellent Prime-mover of Science, Technology, and Innovation for Regional and Countryside Development. Our Mission: Spearhead Scientific, Technological, and Innovation efforts and ensure these results to maximum economic and social benefits for the people in the region.",
        options: [
            { label: "Meet our Director", next: "director_info" },
            { label: "Learn about our programs", next: "services" },
            { label: "View our facilities", next: "equipment" },
            { label: "Back to About Us", next: "about_pstc" }
        ]
    },

    location: {
        message: "PSTC-Kalinga is located in Tabuk City, Kalinga Province, Cordillera Administrative Region. We serve all municipalities of Kalinga including Tabuk, Lubuagan, Pasil, Pinukpuk, Rizal, Tanudan, Tinglayan, and Balbalan.",
        options: [
            { label: "How to get here", next: "directions" },
            { label: "Our coverage areas", next: "coverage" },
            { label: "Back to About Us", next: "about_pstc" }
        ]
    },

    services: {
        message: "PSTC-Kalinga offers various science and technology services to support local development:",
        options: [
            { label: "Technology Transfer & Technical Support", next: "tech_transfer" },
            { label: "Community Empowerment (CEST)", next: "community_empowerment" },
            { label: "S&T Promotion & Capability Building", next: "st_promotion" },
            { label: "Scholarship Programs", next: "scholarship_programs" }
        ]
    },

    tech_transfer: {
        message: "Our Technology Transfer & Technical Support includes: Small Enterprise Technology Upgrading Program (SETUP), Technology Needs Assessment and Upgrading, and Innovation support for MSMEs (Micro, Small, and Medium Enterprises).",
        options: [
            { label: "SETUP Program Details", next: "setup_program" },
            { label: "Technology Assessment", next: "tech_assessment" },
            { label: "MSME Innovation Support", next: "msme_support" },
            { label: "Back to Services", next: "services" }
        ]
    },

    community_empowerment: {
        message: "Community Empowerment through Science and Technology (CEST) provides assistance in education, health, livelihood, environment, and Disaster Risk Reduction Management (DRRM) for marginalized communities in Kalinga.",
        options: [
            { label: "Education Assistance", next: "education_assistance" },
            { label: "Health Programs", next: "health_programs" },
            { label: "Livelihood Support", next: "livelihood_support" },
            { label: "Environmental Programs", next: "environmental_programs" },
            { label: "DRRM Assistance", next: "drrm_assistance" },
            { label: "Back to Services", next: "services" }
        ]
    },

    st_promotion: {
        message: "S&T Promotion and Capability Building includes: Seminars, training, and workshops for schools, LGUs, and cooperatives, as well as Innovation and research competitions to promote science and technology awareness.",
        options: [
            { label: "School Programs", next: "school_programs" },
            { label: "LGU Training", next: "lgu_training" },
            { label: "Cooperative Development", next: "cooperative_dev" },
            { label: "Innovation Competitions", next: "innovation_competitions" },
            { label: "Back to Services", next: "services" }
        ]
    },

    scholarship_programs: {
        message: "PSTC-Kalinga facilitates various DOST scholarship programs: DOST-SEI Undergraduate and Graduate Scholarships for higher education, and Junior Level Science Scholarship (JLSS) for deserving students.",
        options: [
            { label: "Undergraduate Scholarships", next: "undergrad_scholarships" },
            { label: "Graduate Scholarships", next: "grad_scholarships" },
            { label: "JLSS Program", next: "jlss_program" },
            { label: "Application Process", next: "scholarship_application" },
            { label: "Back to Services", next: "services" }
        ]
    },

    director_info: {
        message: "PSTC-Kalinga is headed by Director Jasmin L. Donaal, who leads our team in advancing science and technology initiatives throughout Kalinga Province and ensuring effective implementation of our programs and services.",
        options: [
            { label: "Contact the Director", next: "director_contact" },
            { label: "Office Hours", next: "office_hours" },
            { label: "Back to Mission & Vision", next: "mission_vision" }
        ]
    },

    equipment: {
        message: "PSTC-Kalinga is equipped with modern facilities and equipment to support our programs:",
        options: [
            { label: "Agricultural Machinery", next: "agri_equipment" },
            { label: "Furniture & Woodworking", next: "furniture_woodworking" },
            { label: "Conference & Training Facilities", next: "facilities" },
            { label: "Back to Main Menu", next: "start" }
        ]
    },

    agri_equipment: {
        message: "Our agricultural equipment includes: Rice mills and grain dryers, Organic fertilizer production equipment, Food processing machinery, Irrigation system components, Farm tools and implements, and Demonstration plots for various crops.",
        options: [
            { label: "Rice Processing Equipment", next: "rice_processing" },
            { label: "Food Processing Equipment", next: "food_processing" },
            { label: "Demonstration Areas", next: "demo_plots" },
            { label: "Back to Equipment", next: "equipment" }
        ]
    },

    training: {
        message: "We offer various training programs: Organic farming techniques, Food processing and preservation, Integrated pest management, Climate-smart agriculture, Entrepreneurship development, and Technology adoption workshops.",
        options: [
            { label: "Upcoming Training Schedule", next: "training_schedule" },
            { label: "How to Register", next: "registration" },
            { label: "Training Certificates", next: "certificates" },
            { label: "Back to Services", next: "services" }
        ]
    },

    contact: {
        message: "Get in touch with PSTC-Kalinga DOST: Address: Bulanao, Tabuk City, Kalinga, Phone: 0917 167 5498, Email: pstc-kalinga@car.dost.gov.ph , Office Hours: Monday to Friday, 8:00 AM - 5:00 PM",
        options: [
            { label: "Schedule a Visit", next: "schedule_visit" },
            { label: "Request Information", next: "request_info" },
            { label: "Emergency Contacts", next: "emergency_contacts" },
            { label: "Back to Main Menu", next: "start" }
        ]
    },


    setup_program: {
        message: "The Small Enterprise Technology Upgrading Program (SETUP) provides financial and technical assistance to small enterprises for technology acquisition, upgrading, and innovation to improve their competitiveness and productivity.",
        options: [
            { label: "Eligibility Requirements", next: "setup_eligibility" },
            { label: "Application Process", next: "setup_application" },
            { label: "Success Stories", next: "setup_success" },
            { label: "Back to Technology Transfer", next: "tech_transfer" }
        ]
    },

    msme_support: {
        message: "Our MSME Innovation Support provides technical assistance, consultancy services, technology upgrading guidance, and linkages to research institutions to help micro, small, and medium enterprises adopt new technologies and improve their operations.",
        options: [
            { label: "Technical Consultancy", next: "technical_consultation" },
            { label: "Technology Upgrading", next: "technology_upgrading" },
            { label: "Research Linkages", next: "research_linkages" },
            { label: "Back to Technology Transfer", next: "tech_transfer" }
        ]
    },

    jlss_program: {
        message: "The Junior Level Science Scholarship (JLSS) is designed for high school students who show exceptional aptitude in science and mathematics, providing them with scholarship support to pursue science-related courses in college.",
        options: [
            { label: "JLSS Requirements", next: "jlss_requirements" },
            { label: "Application Timeline", next: "jlss_timeline" },
            { label: "Benefits & Coverage", next: "jlss_benefits" },
            { label: "Back to Scholarship Programs", next: "scholarship_programs" }
        ]
    },

    partnerships: {
        message: "PSTC-Kalinga partners with: Local Government Units of Kalinga, State Universities and Colleges, Other DOST Regional Offices, International development organizations, Private sector companies, and Indigenous communities for collaborative research and development.",
        options: [
            { label: "University Collaborations", next: "university_collab" },
            { label: "LGU Partnerships", next: "lgu_partnerships" },
            { label: "Community Engagement", next: "community_engagement" },
            { label: "Back to Technology Transfer", next: "tech_transfer" }
        ]
    },

    schedule_visit: {
        message: "To schedule a visit to PSTC-Kalinga: Call us during office hours, Send an email with your preferred date and time, Specify the purpose of your visit, and Allow at least 3 days advance notice for proper accommodation.",
        options: [
            { label: "Group Visit Requirements", next: "group_visit" },
            { label: "Individual Consultation", next: "individual_consult" },
            { label: "Research Collaboration", next: "research_collab" },
            { label: "Back to Contact", next: "contact" }
        ]
    },

    end_chat: {
        message: "Thank you for contacting PSTC-Kalinga DOST! We're committed to advancing science and technology for Kalinga's development. Have a great day!",
        options: [
            { label: "Start Over", next: "start" }
        ]
    },
    thank_you: {
        message: "Thank you for chatting with us!",
        options: [
            { label: "Start Over", next: "start" }
        ]
    }
};

const loadDialog = (step) => {
    const currentStep = dialogFlow[step];

    chatbox.innerHTML += `
        <div class="chat incoming thinking">
            <div class="chat-icon">
                <img src="{{ asset('images/DOST.png') }}" alt="Chat Icon" class="chat-icon-img">
            </div>
            <div class="chat-text">
                <p>Thinking...</p>
            </div>
        </div>`;

    chatbox.scrollTo(0, chatbox.scrollHeight);

    setTimeout(() => {
        document.querySelector('.thinking')?.remove();

        if (!currentStep) {
                    if (!currentStep) {
            // Use the thank_you step instead of hardcoded message
            loadDialog('thank_you');
            return;
        }
        
            chatbox.innerHTML += `
                <div style="color: black;" class="chat incoming">
                    <div class="chat-icon">
                        <img src="{{ asset('images/DOST.png') }}" alt="Chat Icon" class="chat-icon-img">
                    </div>
                    <div class="chat-text">
                        <p>Thank you for chatting with us!</p>
                    </div>
                </div>`;
            dialogOptions.innerHTML = '';
            return;
        }

        chatbox.innerHTML += `
    <div class="chat incoming previous-dialog" data-step="${step}">
        <div class="chat-icon">
            <img src="{{ asset('images/DOST.png') }}" alt="Chat Icon" class="chat-icon-img">
        </div>
        <div class="chat-text">
            <p>${currentStep.message}</p>
        </div>
    </div>`;

        const optionsContainer = document.createElement('div');
optionsContainer.classList.add('chat', 'incoming');

const optionsText = document.createElement('div');
optionsText.classList.add('chat-text', 'dialog-options');

currentStep.options.forEach(option => {
    const button = document.createElement('button');
    button.textContent = option.label;
    button.addEventListener('click', () => handleOptionClick(option.label, option.next));
    optionsText.appendChild(button);
});

optionsContainer.appendChild(optionsText);
chatbox.appendChild(optionsContainer);


        chatbox.scrollTo(0, chatbox.scrollHeight);
    }, 1000);
};

const handleOptionClick = (label, next) => {
    chatbox.innerHTML += `
        <div class="chat outgoing">
            <p>${label}</p>
        </div>`;

    chatbox.scrollTo(0, chatbox.scrollHeight);

    loadDialog(next);
};


sendChatBtn.addEventListener('click', () => {
let userMessage = chatInput.value.trim().toLowerCase();
if (!userMessage) return;

chatbox.innerHTML += `<div class="chat outgoing"><p>${chatInput.value}</p></div>`;
chatInput.value = "";
chatbox.scrollTo(0, chatbox.scrollHeight);

let matchedStep = Object.keys(dialogFlow).find(key => key.includes(userMessage.replace(/ /g, "_")));
loadDialog(matchedStep || "start");
});



const handleChat = () => {
userMessage = chatInput.value.trim();
if(!userMessage) return;
chatInput.value = "";
chatInput.style.height = `${chatInput.scrollHeight}px`;

chatbox.appendChild(createChatLi(userMessage, "outgoing"));
chatbox.scrollTo(0, chatbox.scrollHeight);        //auto scroll chat

setTimeout(() => {

    const incomingChatLi = createChatLi("Thinking...", "incoming");
    chatbox.appendChild(incomingChatLi);
    chatbox.scrollTo(0, chatbox.scrollHeight);     
    chatbox.offsetHeight; 
    generateResponse(incomingChatLi);
}, 600);
}

chatbox.addEventListener('click', (e) => {
    const button = e.target.closest('.chat-text button'); 
    if (button) {
        const optionLabel = button.textContent;
        const optionNext = dialogFlow[button.closest('.previous-dialog').dataset.step].options.find(option => option.label === optionLabel).next;
        handleOptionClick(optionLabel, optionNext);
    }
});

chatInput.addEventListener("input", () => {

chatInput.style.height = `${inputInitHeight}px`;
chatInput.style.height = `${chatInput.scrollHeight}px`;
});

chatInput.addEventListener("keydown", (e) => {
if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
    e.preventDefault();
    sendChatBtn.click();
}
});

chatTextarea.addEventListener("input", () => {
chatTextarea.style.height = "55px"; 
chatTextarea.style.height = `${chatTextarea.scrollHeight}px`; 
dialogOptions.style.bottom = `${chatTextarea.scrollHeight + 10}px`;
});

chatInput.addEventListener("input", () => {
chatInput.style.height = "55px"; 
chatInput.style.height = chatInput.scrollHeight + "px"; 
});

const closeChatbot = () => {
chatbot.style.display = 'none';
};


chatbotToggler.addEventListener("click", () => {
        if (!document.body.classList.contains("show-chatbot")) {
            // new chatbot session
            document.body.classList.add("show-chatbot");
            chatbot.classList.remove("minimized");
            isMinimized = false;
            chatbox.innerHTML = "";
            dialogOptions.innerHTML = "";
            loadDialog("start");
        } else if (isMinimized) {
            // minimized
            chatbot.classList.remove("minimized");
            isMinimized = false;
        }
    });

    chatbotCloseBtn.addEventListener("click", () => {//CLOSE FUNCTION
        document.body.classList.remove("show-chatbot");
        chatbot.classList.remove("minimized");
        isMinimized = false;
    });

    minimizeBtn.addEventListener("click", () => {
        chatbot.classList.toggle("minimized");
        isMinimized = !isMinimized;
    });




</script>


</body>

</html>


