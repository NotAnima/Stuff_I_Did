
<style>
.chatbot-container {
    width: 500px;
    margin: 0 auto;
    background-color: rgb(0, 170, 108);
    border: 1px solid #cccccc;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

#chatbot {
    background-color: #f5f5f5;
    border: 1px solid #eef1f5;
    box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.1);
    border-radius: 4px;
  }
  
  #header {
    background-color: rgb(0, 170, 108);
    color: white;
    padding: 20px;
    font-size: 32px;
    font-weight: bold;
  }

  message-container {
    background: #ffffff;
    width: 100%;
    display: flex;
    align-items: center;
  }
  
  
  #conversation {
    height: 500px;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
  }

  @keyframes message-fade-in {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .chatbot-message {
    display: flex;
    align-items: flex-start;
    position: relative;
    font-size: 16px;
    line-height: 20px;
    border-radius: 20px;
    word-wrap: break-word;
    white-space: pre-wrap;
    max-width: 100%;
    padding: 0 15px;
  }

  .user-message {
    justify-content: flex-end;
  }


.chatbot-text {
    background-color: white;
    color: #333333;
    font-size: 1.1em;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  #input-form {
    display: flex;
    align-items: center;
    border-top: 1px solid #eef1f5;
  }
  
  #input-field {
    flex: 1;
    height: 60px;
    border: 1px solid #eef1f5;
    border-radius: 4px;
    padding: 0 10px;
    font-size: 14px;
    transition: border-color 0.3s;
    background: #ffffff;
    color: #333333;
    border: none;
  }

  .send-icon {
    margin-right: 10px;
    cursor: pointer;
  }
  
  #input-field:focus {
    border-color: #333333;
    outline: none;
  }
  
  #submit-button {
    background-color: transparent;
    border: none;
  }

  p[sentTime]:hover::after {    
    content: attr(sentTime);
    position: absolute;
    top: -3px;
    font-size: 14px;
    color: gray;
  }

  .chatbot p[sentTime]:hover::after {  
    left: 15px;
  }

  .user-message p[sentTime]:hover::after {  
    right: 15px;
  }

  /* width */
::-webkit-scrollbar {
    width: 10px;
  }
  
  /* Track */
  ::-webkit-scrollbar-track {
    background: #f1f1f1; 
  }
   
  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #888; 
  }
  
  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: #555; 
  }



</style>

<div class="chatbot-container mt-4 mb-4">
    <div id="header">
        <h1>AdviceTrip Chatbot</h1>
    </div>
    <div id="chatbot">
        <div id="conversation">
            <div class="chatbot-message">
            <p class="chatbot-text">Hi! 👋 it's great to see you!</p>
            </div>
        </div>
        <form id="input-form">
            <message-container>
            <input id="input-field" type="text" placeholder="Type your message here">
            </message-container>
            
        </form>
    </div>
</div>

<script>
const chatbot = document.getElementById('chatbot');
const conversation = document.getElementById('conversation');
const inputForm = document.getElementById('input-form');
const inputField = document.getElementById('input-field');

const API_KEY = "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";

// Add event listener to input form
inputForm.addEventListener('submit', function(event) {
  // Prevent form submission
  event.preventDefault();

  // Get user input
  const input = inputField.value;

  // Clear input field
  inputField.value = '';
  const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: "2-digit" });

  // Add user input to conversation
  let message = document.createElement('div');
  message.classList.add('chatbot-message', 'user-message');
  message.innerHTML = `<p class="chatbot-text" sentTime="${currentTime}">${input}</p>`;
  conversation.appendChild(message);

  // Generate chatbot response
  const getChatResponse = async (generateResponse) => {
    const API_URL = "https://api.openai.com/v1/chat/completions";

    const headers = {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${API_KEY}`
    };

    const data = {
      'model': 'gpt-3.5-turbo',
      'messages': [{'role': 'user', 'content': input}],
      'max_tokens': 1024
    };

    try {
      const response = await fetch(API_URL, {
        method: 'POST',
        headers,
        body: JSON.stringify(data)
      });
      console.log(response);

      const result = await response.json();
      console.log(result);
      const reply = result.choices[0].message.content;
      message = document.createElement('div');
      message.classList.add('chatbot-message','chatbot');
      message.innerHTML = `<p class="chatbot-text" sentTime="${currentTime}">${reply}</p>`;
      conversation.appendChild(message);
      message.scrollIntoView({behavior: "smooth"});
    } catch (error) {
      const reply = "Error: Something went wrong when retrieving the response. Please try again."
      message = document.createElement('div');
      message.classList.add('chatbot-message','chatbot');
      message.innerHTML = `<p class="chatbot-text" sentTime="${currentTime}">${reply}</p>`;
      conversation.appendChild(message);
      message.scrollIntoView({behavior: "smooth"});
    }
  }

  getChatResponse();
});

</script>