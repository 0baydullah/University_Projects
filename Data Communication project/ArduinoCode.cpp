unsigned long previousMillis  = 0;
unsigned long interval        = 1000;
bool          LED_BLINK       = false;

void setup() {
  Serial.begin(9600);
  pinMode(LED, OUTPUT);
}

void loop() {

  while( Serial.available() ){
    
    char command = Serial.read();
    switch(command){
      case 'a':
        digitalWrite(LED, LOW);
        break;
      case 'A':
        digitalWrite(LED, HIGH);
        break;

      case 'b':
        digitalWrite(LED, LOW);
        LED_BLINK = false;
        break ;

      case 'B':
        LED_BLINK = true;
        break;

      case 'c':
        digitalWrite(LED, LOW);
        LED_BLINK = false;
        interval = 1000;
        break ;

      case 'C':
        LED_BLINK = true;
        interval = 200;
        break;
        
      default:
        Serial.println("Unknown command");
        break;
    }
  }

  if ( LED_BLINK ){
    unsigned long currentMillis = millis();
    if (currentMillis - previousMillis >= interval) {
      previousMillis = currentMillis;
      if (digitalRead(LED) == LOW) {
        digitalWrite(LED, HIGH);
      } else {
        digitalWrite(LED, LOW);
      }
    }
  }
  

}