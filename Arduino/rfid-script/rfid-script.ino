/*
Collegamenti:
 
RC522 MODULE    Uno/Nano    
SDA             D10
SCK             D13
MOSI            D11
MISO            D12
IRQ             N/A
GND             GND
RST             D9
3.3V            3.3V
*/
 
#include <SPI.h>
#include <RFID.h>
/* Vengono definiti PIN del RFID reader*/
#define SDA_DIO 10  // 53 per Mega
#define RESET_DIO 9
#define delayRead 1000 // Time of delay 
 
RFID RC522(SDA_DIO, RESET_DIO); 

const String codiceGiusto = "9439B1ACB";     //codice da assegnare come "VALIDO" le maiuscole/minuscole sono ignorate

#define ledR 2
#define ledG 3
#define ledB 4

void setup()
{ 
  Serial.begin(9600);
  /* Abilita SPI*/
  SPI.begin();                  //Inizializzazione dell'SPI
  RC522.init();                 //Inizializzazione dell'RFID Reader

  pinMode(ledR, OUTPUT);
  pinMode(ledG, OUTPUT);
  pinMode(ledB, OUTPUT);
}
  
void loop()
{
  byte i;   
  // Se viene letta una tessera
  if (RC522.isCard())
  {
    // Viene letto il suo codice 
    RC522.readCardSerial();
    String codiceLetto ="";
    //Lettura del codice della scheda e composizione della stringa
    for(i = 0; i <= 4; i++)
    {
      codiceLetto+= String(RC522.serNum[i],HEX);
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
  }
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
