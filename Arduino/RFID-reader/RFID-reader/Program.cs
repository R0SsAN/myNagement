﻿using System;
using System.Collections.Generic;
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

            arduino = new SerialPort("COM14", 9600);
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
            Console.Write("Tag rilevato! ID = {" + lettura + "}");
            inviaRichiesta(lettura);
        }
        static void inviaRichiesta(string id)
        {
            

            /*var values = string.Format("rfid="+id);
            var bytes = Encoding.ASCII.GetBytes(values);
            HttpWebRequest request = (HttpWebRequest)WebRequest.Create(string.Format("http://localhost/esercizi/Github/myNagement/Sito/PHP/arduino_api.php"));
            request.Method = "PUT";
            request.ContentType = "application/x-www-form-urlencoded";
            using (var requestStream = request.GetRequestStream())
            {
                requestStream.Write(bytes, 0, bytes.Length);
            }
            var response = (HttpWebResponse)request.GetResponse();
            var encoding = ASCIIEncoding.ASCII;
            using (var reader = new System.IO.StreamReader(response.GetResponseStream(), encoding))
            {
                string risposta = reader.ReadToEnd();
                if (risposta == "true")
                {
                    Console.WriteLine("Presenza segnata con successo! \n ");
                    arduino.Write("true;");
                    return;
                }
                else if(risposta=="false")
                {
                    Console.WriteLine("Presenza già segnata o id non valido! \n ");
                    arduino.Write("false;");
                    return;
                }
            }
            Console.WriteLine("Errore generico");
            arduino.Write("false;");
            */
            Console.WriteLine(id);
            arduino.Write("true;");
            Dictionary<string, string> pairs = new Dictionary<string, string>()
            {
                {"id", id },
            };
            bool p = PostMethod("url", pairs);
        }




        public static bool PostMethod(string url, Dictionary<string, string> postValues)
        {
            HttpClient client = new HttpClient();
            try
            {
                var response = client.PostAsync(url, new FormUrlEncodedContent(postValues)).Result;
                string ris = response.Content.ReadAsStringAsync().Result;
                return Boolean.Parse(ris);
            }
            catch (Exception)
            {
                return false;
            }
        }
    }
}
