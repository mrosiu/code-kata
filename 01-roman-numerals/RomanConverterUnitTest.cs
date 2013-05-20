using System;
using Microsoft.VisualStudio.TestTools.UnitTesting;

namespace RomanConverterTests
{
    [TestClass]
    public class RomanConverterUnitTest
    {
        [TestMethod]
        public void SimpleNumbersShouldEqual()
        {
            var conv = new RomanConverter.RomanConverter();
            
            Assert.AreEqual("I", conv.Convert(1));
            Assert.AreEqual("V", conv.Convert(5));
            Assert.AreEqual("X", conv.Convert(10));
        }

        [TestMethod]
        public void ComplexNumbersShouldEqual()
        {
            var conv = new RomanConverter.RomanConverter();
            
            Assert.AreEqual("II", conv.Convert(2));
            Assert.AreEqual("LXXXVIII", conv.Convert(88));
            Assert.AreEqual("DI", conv.Convert(501));
            Assert.AreEqual("DCCCXC", conv.Convert(890));
            Assert.AreEqual("MDCCC", conv.Convert(1800));
            Assert.AreEqual("MMDCLXIV", conv.Convert(2664));
        }
    }
}
