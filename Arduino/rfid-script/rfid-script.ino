#include <SPI.h>
#include <RFID.h>

#define SS_PIN 10
#define RST_PIN 9

RFID rfid(SS_PIN, RST_PIN); 

// Setup variables:
    int serNum0;
    int serNum1;
    int serNum2;
    int serNum3;
    int serNum4;

#define ledR 2
#define ledG 3
#define ledB 4

void setup()
{ 
  Serial.begin(9600);
  SPI.begin(); 
  rfid.init();

  pinMode(ledR, OUTPUT);
  pinMode(ledG, OUTPUT);
  pinMode(ledB, OUTPUT);
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
      analogWrite(ledR,0);
      analogWrite(ledG,255);
      analogWrite(ledB,0);
      delay(1500);
      spegniLed();
    }
    else if(risposta=="false")
    {
      analogWrite(ledR,255);
      analogWrite(ledG,0);
      analogWrite(ledB,0);
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
