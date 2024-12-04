using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Drawing.Imaging;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace VisualImagenes
{
    public partial class Form1 : Form
    {
        int R, G, B;
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            openFileDialog1.Filter = "Archivos PNG|*.png|Archivos JPG|*.jpg";
            openFileDialog1.ShowDialog();
            Bitmap bmp = new Bitmap(openFileDialog1.FileName);
            pictureBox1.Image = bmp;
        }

        private void pictureBox1_MouseClick(object sender, MouseEventArgs e)
        {
       
           Color c = new Color();
           Bitmap bmp = new Bitmap(pictureBox1.Image);
           R=0;
           G=0;
           B=0;
           for (int i=e.X;i<e.X+10;i++)
               for (int j = e.Y; j < e.Y + 10; j++)
               {
                   c = bmp.GetPixel(i, j);
                   R = R + c.R;
                   G = G + c.G;
                   B = B + c.B;
               }
           R = R / 100;
           G = G / 100;
           B = B / 100;
           textBox1.Text = R.ToString();
           textBox2.Text = G.ToString();
           textBox3.Text = B.ToString();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            Bitmap bmp = new Bitmap(pictureBox1.Image);
            Bitmap bmp2 = new Bitmap(bmp.Width, bmp.Height);

            for (int x = 0; x < bmp.Width; x++)
            {
                for (int y = 0; y < bmp.Height; y++)
                {
                    Color c = bmp.GetPixel(x, y);
                    int average = (c.R + c.G + c.B) / 3;

                    // Detectar blancos y asignar a azul/violeta
                    if (c.R > 240 && c.G > 240 && c.B > 240)
                    {
                        bmp2.SetPixel(x, y, Color.Blue); // Fondo blanco como frío
                    }
                    else if (average > 200)
                    {
                        bmp2.SetPixel(x, y, Color.Yellow); // Cálido
                    }
                    else if (average > 150)
                    {
                        bmp2.SetPixel(x, y, Color.Orange); // Más cálido
                    }
                    else if (average > 100)
                    {
                        bmp2.SetPixel(x, y, Color.Red); // Muy cálido
                    }
                    else if (average > 50)
                    {
                        bmp2.SetPixel(x, y, Color.Purple); // Frío
                    }
                    else
                    {
                        bmp2.SetPixel(x, y, Color.DarkBlue); // Muy frío
                    }
                }
            }

            pictureBox2.Image = bmp2;
        }
 }
}