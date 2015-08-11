# MIB2YAML converts MIB files to YAML files for the Ruby SNMP library with support for imports
#
# The code is heavily based on http://snmplib.rubyforge.org/, the only addition is the "find imports" block

require 'rubygems'
require 'fileutils'
require 'yaml'

module MIB2YAML
  def MIB2YAML.convert(module_file, mib_dir = '.')
    raise "smidump tool must be installed" unless import_supported?
    FileUtils.makedirs mib_dir

    # find imports
    imports = ''

    File.read(module_file).split("\n").each do |i|
      import = i.slice(/FROM [\w-]+/)
      if import != nil
        imports += "-p #{import.gsub('FROM ','')}.mib "
      end
    end

    mib_hash = `smidump -k -f python #{imports} #{module_file}`
    mib = eval_mib_data(mib_hash)
    if mib
      module_name = mib["moduleName"]
      raise "#{module_file}: invalid file format; no module name" unless module_name
      if mib["nodes"]
        oid_hash = {}
        mib["nodes"].each { |key, value| oid_hash[key] = value["oid"] }
        if mib["notifications"]
          mib["notifications"].each { |key, value| oid_hash[key] = value["oid"] }
        end
        File.open(File.join(mib_dir, module_name + '.yaml'), 'w') do |file|
          YAML.dump(oid_hash, file)
          file.puts
        end
        puts "File converted"
      else
        puts "*** No nodes defined in: #{module_file} ***"
      end
    else
        puts "*** Import failed for: #{module_file} ***"
    end
  end

  def MIB2YAML.import_supported?
    `smidump --version` =~ /^smidump 0.4/  && $? == 0
  end

  private
  def MIB2YAML.eval_mib_data(mib_hash)
    ruby_hash = mib_hash.
      gsub(':', '=>').                  # fix hash syntax
      gsub('(', '[').gsub(')', ']').    # fix tuple syntax
      sub('FILENAME =', 'filename =').  # get rid of constants
      sub('MIB =', 'mib =')
    mib = nil
    eval(ruby_hash)
    mib
  end
end

if ARGV.length < 1
  puts "Usage: mib2yaml <mibfile>"
else
  MIB2YAML::convert(ARGV[0])
end
