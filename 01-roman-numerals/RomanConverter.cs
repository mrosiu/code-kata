using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace RomanConverter
{
    public class RomanConverter
    {
        protected Dictionary<int, string> conversions;

        public RomanConverter()
        {
            conversions = new Dictionary<int, string>()
            {
                { 1000, "M" },
                { 900, "CM" },
                { 500, "D" },
                { 400, "CD" },
                { 100, "C" },
                { 90, "XC" },
                { 50, "L" },
                { 40, "XL" },
                { 10, "X" },
                { 9, "IX" },
                { 5, "V" },
                { 4, "IV" },
                { 1, "I" }
            };

        }
        
        public string Convert(int arabic)
        {
            string roman = "";

            foreach (var conv in conversions)
            {
                while (arabic >= conv.Key)
                {
                    roman += conv.Value;
                    arabic -= conv.Key;
                }
                if (arabic == 0)
                    break;
            }
            return roman;
        }
    }
}
