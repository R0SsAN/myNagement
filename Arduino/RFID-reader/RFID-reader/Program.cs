using System;
using System.Collections.Generic;
using System.IO;
using System.IO.Ports;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

namespace RFID_reader
{
    class Program
    {
        static SerialPort arduino;
        static void Main(string[] args)
        {
            string porta = File.ReadAllText("config.txt");
            arduino = new SerialPort(porta, 9600);
            try
            {
                arduino.Open();
            }
            catch(Exception e)
            {
                Console.WriteLine("Errore connessione seriale!");
                Console.ReadLine();
            }
            
            arduino.DataReceived += Arduino_DataReceived;

            Console.WriteLine("Servizio lettore tessere avviato!");
            Console.WriteLine("In attesa di tessere..");
            while (true) { }
        }

        private static void Arduino_DataReceived(object sender, SerialDataReceivedEventArgs e)
        {
            Thread.Sleep(200);
            string lettura = arduino.ReadExisting();
            Console.Write("Tag rilevato! ID = {" + lettura + "} ....     ");
            inviaRichiesta(lettura);
        }
        static void inviaRichiesta(string id)
        {

            Dictionary<string, string> pairs = new Dictionary<string, string>()
            {
                {"rfid", id },
            };
            string response = PostMethod("http://localhost/esercizi/Github/myNagement/Sito/php/arduino_api.php", pairs);
            if(response=="true")
            {
                Console.WriteLine("Richiesta accettata!");
                arduino.Write("true;");
            }
            else
            {
                Console.WriteLine("Richiesta rifiutata!");
                arduino.Write("false;");
            }
        }
        static string PostMethod(string url, Dictionary<string, string> postValues)
        {
            HttpClient client = new HttpClient();
            try
            {
                var response = client.PostAsync(url, new FormUrlEncodedContent(postValues)).Result;
                string ris = response.Content.ReadAsStringAsync().Result;
                return ris;
            }
            catch (Exception)
            {
                return "false";
            }
        }
    }
}
