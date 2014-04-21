
from __future__ import print_function

import logging
import os
import shutil
import sys
import tempfile

from optparse import OptionParser
from qtfaststart import VERSION
from qtfaststart import processor
from qtfaststart.exceptions import FastStartException

log = logging.getLogger("qtfaststart")

def run():
    logging.basicConfig(level = logging.INFO, stream = sys.stdout,
                        format = "%(message)s")

    parser = OptionParser(usage="%prog [options] infile [outfile]",
                          version="%prog " + VERSION)

    parser.add_option("-d", "--debug", dest="debug", default=False,
                      action="store_true",
                      help="Enable debug output")
    parser.add_option("-l", "--list", dest="list", default=False,
                      action="store_true",
                      help="List top level atoms")
    parser.add_option("-e", "--to_end", dest="to_end", default=False,
                      action="store_true",
                      help="Move moov atom to the end of file")
    parser.add_option("-s", "--sample", dest="sample", default=False,
                      action="store_true",
                      help="Create a small sample of the input file")

    options, args = parser.parse_args()

    if len(args) < 1:
        parser.print_help()
        raise SystemExit(1)

    if options.debug:
        logging.getLogger().setLevel(logging.DEBUG)

    if options.list:
        index = processor.get_index(open(args[0], "rb"))

        for atom, pos, size in index:
            if atom == "\x00\x00\x00\x00":
                # Strange zero atom... display with dashes rather than
                # an empty string
                atom = "----"

            print(atom, "(" + str(size) + " bytes)")

        raise SystemExit

    if len(args) == 1:
        # Replace the original file!
        if options.sample:
            print("Please pass an output filename when used with --sample!")
            raise SystemExit(1)

        tmp, outfile = tempfile.mkstemp()
        os.close(tmp)
    else:
        outfile = args[1]

    limit = 0
    if options.sample:
        # Create a small sample (4 MiB)
        limit = 4 * (1024 ** 2)

    try:
        processor.process(args[0], outfile, limit = limit, to_end = options.to_end)
    except FastStartException:
        # A log message was printed, so exit with an error code
        raise SystemExit(1)

    if len(args) == 1:
        # Move temp file to replace original
        shutil.move(outfile, args[0])
