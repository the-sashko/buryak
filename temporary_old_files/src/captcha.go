/*

import (
	"log"

	"github.com/fogleman/gg"
)

func main() {
	const S = 1024
	im, err := gg.LoadImage("hello.png")
	if err != nil {
		log.Fatal(err)
	}

	dc := gg.NewContext(S, S)
	dc.SetRGB(1, 1, 1)
	dc.Clear()
	dc.SetRGB(0, 0, 0)
	if err := dc.LoadFontFace("/Library/Fonts/Arial.ttf", 96); err != nil {
		panic(err)
	}
	dc.DrawStringAnchored("Hello, world!", S/2, S/2, 0.5, 0.5)

	dc.DrawRoundedRectangle(0, 0, 512, 512, 0)
	dc.DrawImage(im, 0, 0)
	dc.DrawStringAnchored("Hello, world!", S/2, S/2, 0.5, 0.5)
	dc.Clip()
	dc.SavePNG("out.png")
}
*/
/*
package main

import (
	"bufio"
	"flag"
	"fmt"
	"github.com/golang/freetype"
	"github.com/golang/freetype/truetype"
	"golang.org/x/image/font"
	"image"
	"image/color"
	"image/draw"
	"image/png"
	"io/ioutil"
	"log"
	"os"
)

var (
	dpi      = flag.Float64("dpi", 72, "screen resolution in Dots Per Inch")
	fontfile = flag.String("fontfile", "res/fonts/FiraMonoBold.ttf", "filename of the ttf font")
	hinting  = flag.String("hinting", "none", "none | full")
	size     = flag.Float64("size", 125, "font size in points")
	spacing  = flag.Float64("spacing", 1.5, "line spacing (e.g. 2 means double spaced)")
	wonb     = flag.Bool("whiteonblack", false, "white text on a black background")
	text     = string("JOJO")
)

func main() {
	flag.Parse()
	fmt.Printf("Loading fontfile %q\n", *fontfile)
	b, err := ioutil.ReadFile(*fontfile)
	if err != nil {
		log.Println(err)
		return
	}
	f, err := truetype.Parse(b)
	if err != nil {
		log.Println(err)
		return
	}

	// Freetype context
	fg, bg := image.Black, image.White
	rgba := image.NewRGBA(image.Rect(0, 0, 1000, 200))
	draw.Draw(rgba, rgba.Bounds(), bg, image.ZP, draw.Src)
	c := freetype.NewContext()
	c.SetDPI(*dpi)
	c.SetFont(f)
	c.SetFontSize(*size)
	c.SetClip(rgba.Bounds())
	c.SetDst(rgba)
	c.SetSrc(fg)
	switch *hinting {
	default:
		c.SetHinting(font.HintingNone)
	case "full":
		c.SetHinting(font.HintingFull)
	}

	// Make some background

	// Draw the guidelines.
	ruler := color.RGBA{0xdd, 0xdd, 0xdd, 0xff}
	for rcount := 0; rcount < 4; rcount++ {
		for i := 0; i < 200; i++ {
			rgba.Set(250*rcount, i, ruler)
		}
	}

	// Truetype stuff
	opts := truetype.Options{}
	opts.Size = 125.0
	face := truetype.NewFace(f, &opts)

	// Calculate the widths and print to image
	for i, x := range text {
		awidth, ok := face.GlyphAdvance(rune(x))
		if ok != true {
			log.Println(err)
			return
		}
		iwidthf := int(float64(awidth) / 64)
		fmt.Printf("%+v\n", iwidthf)

		pt := freetype.Pt(i*250+(125-iwidthf/2), 128)
		c.DrawString(string(x), pt)
		fmt.Printf("%+v\n", awidth)
	}

	// Save that RGBA image to disk.
	outFile, err := os.Create("out.png")
	if err != nil {
		log.Println(err)
		os.Exit(1)
	}
	defer outFile.Close()
	bf := bufio.NewWriter(outFile)
	err = png.Encode(bf, rgba)
	if err != nil {
		log.Println(err)
		os.Exit(1)
	}
	err = bf.Flush()
	if err != nil {
		log.Println(err)
		os.Exit(1)
	}
	fmt.Println("Wrote out.png OK.")

}
*/

package main

import (
	"bufio"
	"fmt"
	"image"
	"image/color"
	"image/draw"
	"image/png"
	"io/ioutil"
	"os"

	"github.com/golang/freetype"
	"github.com/golang/freetype/truetype"
)

var (
	backgroundWidth  = 650
	backgroundHeight = 150
	utf8FontFile     = "res/fonts/FiraMonoBold.ttf"
	utf8FontSize     = float64(15.0)
	spacing          = float64(1.5)
	dpi              = float64(72)
	ctx              = new(freetype.Context)
	utf8Font         = new(truetype.Font)
	red              = color.RGBA{255, 0, 0, 255}
	blue             = color.RGBA{0, 0, 255, 255}
	white            = color.RGBA{255, 255, 255, 255}
	black            = color.RGBA{0, 0, 0, 255}
	background       *image.RGBA
	// more color at https://github.com/golang/image/blob/master/colornames/table.go
)

func main() {

	// download font from http://www.slackware.com/~alien/slackbuilds/wqy-zenhei-font-ttf/build/wqy-zenhei-0.4.23-1.tar.gz
	// extract wqy-zenhei.ttf to the same folder as this program

	// Read the font data - for this example, we load the Chinese fontfile wqy-zenhei.ttf,
	// but it will display any utf8 fonts such as Russian, Japanese, Korean, etc as well.
	// some utf8 fonts cannot be displayed. You need to use your own language .ttf file
	fontBytes, err := ioutil.ReadFile(utf8FontFile)
	if err != nil {
		fmt.Println(err)
		return
	}

	utf8Font, err = freetype.ParseFont(fontBytes)
	if err != nil {
		fmt.Println(err)
		return
	}

	fontForeGroundColor, fontBackGroundColor := image.NewUniform(black), image.NewUniform(white)

	background = image.NewRGBA(image.Rect(0, 0, backgroundWidth, backgroundHeight))

	draw.Draw(background, background.Bounds(), fontBackGroundColor, image.ZP, draw.Src)

	ctx = freetype.NewContext()
	ctx.SetDPI(dpi) //screen resolution in Dots Per Inch
	ctx.SetFont(utf8Font)
	ctx.SetFontSize(utf8FontSize) //font size in points
	ctx.SetClip(background.Bounds())
	ctx.SetDst(background)
	ctx.SetSrc(fontForeGroundColor)

	var UTF8text = []string{
		`English - Hello, Chinese - 你好, Russian - Здравствуйте, Korean - 여보세요, Greek - Χαίρετε`,
		`Tajik - Салом, Japanese - こんにちは, Icelandic - Halló, Belarusian - добры дзень`,
		`symbols - © Ø ® ß ◊ ¥ Ô º ™ € ¢ ∞ § Ω`,
	}

	// Draw the text to the background
	pt := freetype.Pt(10, 10+int(ctx.PointToFixed(utf8FontSize)>>6))

	// not all utf8 fonts are supported by wqy-zenhei.ttf
	// use your own language true type font file if your language cannot be printed

	for _, str := range UTF8text {
		_, err := ctx.DrawString(str, pt)
		if err != nil {
			fmt.Println(err)
			return
		}
		pt.Y += ctx.PointToFixed(utf8FontSize * spacing)
	}

	// Save
	outFile, err := os.Create("utf8text.png")
	if err != nil {
		fmt.Println(err)
		os.Exit(-1)
	}
	defer outFile.Close()
	buff := bufio.NewWriter(outFile)

	err = png.Encode(buff, background)
	if err != nil {
		fmt.Println(err)
		os.Exit(-1)
	}

	// flush everything out to file
	err = buff.Flush()
	if err != nil {
		fmt.Println(err)
		os.Exit(-1)
	}
	fmt.Println("Save to utf8text.png")

}
