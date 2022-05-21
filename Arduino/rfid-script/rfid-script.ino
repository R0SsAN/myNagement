#include <SPI.h>
#include <RFID.h>

#define SS_PIN 10
#define RST_PIN 9

#define ledR 5
#define ledG 6
#define ledB 7

#define buzzer 2


RFID rfid(SS_PIN, RST_PIN); 

// Setup variables:
    int serNum0;
    int serNum1;
    int serNum2;
    int serNum3;
    int serNum4;

void setup()
{ 
  Serial.begin(9600);
  SPI.begin(); 
  rfid.init();

  pinMode(ledR, OUTPUT);
  pinMode(ledG, OUTPUT);
  pinMode(ledB, OUTPUT);
  
  pinMode(buzzer, OUTPUT);
}
  
void loop()
{
  byte i;   
  // Se viene letta una tessera
  if (rfid.isCard())
  {
    // Viene letto il suo codice 
    rfid.readCardSerial();
    String codiceLetto ="";
    //Lettura del codice della scheda e composizione della stringa
    for(i = 0; i <= 4; i++)
    {
      codiceLetto+= String(rfid.serNum[i],HEX);
      codiceLetto.toUpperCase();
    }
    //invio l'id letto a c#
    Serial.print(codiceLetto);
    //ora aspetto la risposta da c#
    String risposta=leggiFino(';');
    if(risposta=="true")
    {
      tone(buzzer, 1000, 500);
      digitalWrite(ledR,LOW);
      digitalWrite(ledG,HIGH);
      digitalWrite(ledB,LOW);
      delay(1500);
      spegniLed();
    }
    else if(risposta=="false")
    {
      digitalWrite(ledR,HIGH);
      digitalWrite(ledG,LOW);
      digitalWrite(ledB,LOW);
      tone(buzzer, 300, 500);
      delay(500);
      noTone(buzzer);
      delay(50);
      tone(buzzer, 300, 500);
      
      delay(1500);
      spegniLed();
    }
    delay(250);
  }
  delay(100);
}
void spegniLed()
{
  digitalWrite(ledR, LOW);
  digitalWrite(ledG, LOW);
  digitalWrite(ledB, LOW);
}
String leggiFino(char terminatore)
{
  String temp="";
  //continuo a leggere dalla seriale fino a quando non leggo il carattere terminatore
  while(true)
  {
    if(Serial.available()>0)
    {
      char c=Serial.read();
      if(c==terminatore)
      {
        return temp;
      }
        
      else
        temp+=c;
    }
  }
}
